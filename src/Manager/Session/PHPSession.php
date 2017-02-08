<?php

namespace Esier\Manager\Session;

class PHPSession implements CanStoreInterface
{
    /*
    *	State for declaring that the session has been started
    *
    *	@var boolean
    */
    const SESSION_STARTED = true;

    /*
    *	State for declaring that the session has not been started
    *
    *	@var boolean
    */
    const SESSION_NOT_STARTED = false;

    /*
    *	The current state of the session
    *
    *	@var boolean
    */
    private $sessionState = self::SESSION_NOT_STARTED;

    /*
    *	Name of the cookie to send the current Session ID in
    *
    *	@var string
    */
    protected $name;

    /*
    *	Time limit for the session to live between requests
    *
    *	@var integer
    */
    protected $limit;

    /*
    *	Path on the domain where the cookie will work. use '/' for all paths
    *
    *	@var string
    */
    protected $path;

    /*
    *	Cookie domain. Prefix with . for all subdomains
    *
    *	@var string
    */
    protected $domain;

    /*
    *	Whether cookie will only be sent over secure connections
    *
    *	@var boolean
    */
    protected $secure;

    /*
    *	Initialize values and start session
    *
    *	@param array $config
    *
    *	@return void
    */
    public function __construct(array $config)
    {
        $this->name = $config['name'];
        $this->limit = $config['limit'];
        $this->path = $config['path'];
        $this->domain = $config['domain'];
        $this->secure = $config['secure'];
        $this->startSession();
    }

    /*
    *    (Re)starts the session.
    *
    *    @return boolean
    */
    public function startSession()
    {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            // Set the cookie name before we start.
            session_name($this->name.'_Session');

            // Set the domain to default to the current domain.
            $domain = isset($this->domain) ? $this->domain : isset($_SERVER['SERVER_NAME']);

            // Set the default secure value to whether the site is being accessed with SSL
            $https = isset($this->secure) ? $this->secure : isset($_SERVER['HTTPS']);

            // Set the cookie settings and start the session
            session_set_cookie_params($this->limit, $this->path, $domain, $https, true);
            $this->sessionState = session_start();

            // Make sure the session hasn't expired, and destroy it if it has
            if ($this->validateSession()) {
                // Check to see if the session is new or a hijacking attempt
                if (!$this->preventHijacking()) {
                    // Reset session data and regenerate id
                    $_SESSION = [];
                    $_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
                    $this->regenerateSession();

                // Give a 5% chance of the session id changing on any request
                } elseif (rand(1, 100) <= 5) {
                    $this->regenerateSession();
                }

                return $this->sessionState;
            }
            $_SESSION = [];
            session_destroy();
            session_start();
        }

        return $this->sessionState;
    }

    /*
    *	Determine whether the session has been hijacked
    *
    *	@return boolean
    */
    protected function preventHijacking()
    {
        if (!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent'])) {
            return false;
        }

        if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR']) {
            return false;
        }

        if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']) {
            return false;
        }

        return true;
    }

    /*
    *	Refresh the session with a new ID to prevent attacks
    *
    *	@return void
    */
    protected function regenerateSession()
    {
        // If this session is obsolete it means there already is a new id
        if (isset($_SESSION['OBSOLETE']) || $_SESSION['OBSOLETE'] == true) {
            return;
        }

        // Set current session to expire in 10 seconds
        $_SESSION['OBSOLETE'] = true;
        $_SESSION['EXPIRES'] = time() + 10;

        // Create new session without destroying the old one
        session_regenerate_id(false);

        // Grab current session ID and close both sessions to allow other scripts to use them
        $newSession = session_id();
        session_write_close();

        // Set session ID to the new one, and start it back up again
        session_id($newSession);
        session_start();

        // Now we unset the obsolete and expiration values for the session we want to keep
        unset($_SESSION['OBSOLETE']);
        unset($_SESSION['EXPIRES']);
    }

    /*
    *	Checks whether the session has expired
    *
    *	@return boolean
    */
    protected function validateSession()
    {
        if (isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES'])) {
            return false;
        }

        if (isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()) {
            return false;
        }

        return true;
    }

    /*
    *    Stores datas in the session.
    *
    *    @param name string
    *    @param value mixed
    *
    *    @return void
    */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /*
    *    Gets datas from the session.
    *
    *    @param name string
    *
    *    @return mixed
    */
    public function __get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    /*
    *	Checks whether a value is stored in the session
    *
    *	@param string $name
    *
    *	@return boolean
    */
    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }

    /*
    *	Deletes a value from the session
    *
    *	@param string $name
    *
    *	@return void
    */
    public function __unset($name)
    {
        unset($_SESSION[$name]);
    }

    /*
    *    Destroys the current session.
    *
    *    @return bool
    */
    public function destroy()
    {
        if ($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);

            return !$this->sessionState;
        }

        return false;
    }
}
