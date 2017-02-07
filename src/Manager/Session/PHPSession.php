<?php

namespace Esier\Manager\Session;

class PHPSession implements CanStoreInterface
{
    const SESSION_STARTED = true;
    const SESSION_NOT_STARTED = false;

    // The state of the session
    private $sessionState = self::SESSION_NOT_STARTED;

    protected $name;

    protected $limit;

    protected $path;

    protected $domain;

    protected $secure;

    public function __construct(array $config)
    {
        $this->name = $config['name'];
        $this->limit = $config['limit'];
        $this->path = $config['path'];
        $this->domain = $config['domain'];
        $this->secure = $config['secure'];
        $this->startSession();
    }

    /**
     *    (Re)starts the session.
     *
     *    @return    bool    TRUE if the session has been initialized, else FALSE.
     **/
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

    /**
     *    Stores datas in the session.
     *    Example: $instance->foo = 'bar';.
     *
     *    @param    name    Name of the datas.
     *    @param    value    Your datas.
     *
     *    @return    void
     **/
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     *    Gets datas from the session.
     *    Example: echo $instance->foo;.
     *
     *    @param    name    Name of the datas to get.
     *
     *    @return    mixed    Datas stored in session.
     **/
    public function __get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }

    public function __unset($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     *    Destroys the current session.
     *
     *    @return    bool    TRUE is session has been deleted, else FALSE.
     **/
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
