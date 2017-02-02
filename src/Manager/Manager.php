<?php
namespace Esir\Manager;
use \GuzzleHttp\Client;
class Manager
{
	const AUTH_URL = 'https://login.eveonline.com/oauth/token';
	
	const SSO_URL = 'https://login.eveonline.com/oauth/authorize';
	
	const AVAILABLE_SCOPES = array(
		'assets-read' => 'esi-assets.read_assets.v1',
		'bookmarks-read' => 'esi-bookmarks.read_character_bookmarks.v1',
		'calendar-read' => 'esi-calendar.read_calendar_events.v1',
		'calendar-write' => 'esi-calendar.respond_calendar_events.v1',
		'contacts-read' => 'esi-characters.read_contacts.v1',
		'contacts-write' => 'esi-characters.write_contacts.v1',
		'clones-write' => 'esi-clones.read_clones.v1',
		'corporation-read' => 'esi-corporations.read_corporation_membership.v1',
		'fittings-read' => 'esi-fittings.read_fittings.v1',
		'fittings-write' => 'esi-fittings.write_fittings.v1',
		'fleets-read' => 'esi-fleets.read_fleet.v1',
		'fleets-write' => 'esi-fleets.write_fleet.v1',
		'killmails-read' => 'esi-killmails.read_killmails.v1',
		'location-read' => 'esi-location.read_location.v1',
		'ship-type-read' => 'esi-location.read_ship_type.v1',
		'mail-organize' => 'esi-mail.organize_mail.v1',
		'mail-read' => 'esi-mail.read_mail.v1',
		'mail-send' => 'esi-mail.send_mail.v1',
		'market-read' => 'esi-markets.structure_markets.v1',
		'planets-manage' => 'esi-planets.manage_planets.v1',
		'search-structures' => 'esi-search.search_structures.v1',
		'skills-read-queue' => 'esi-skills.read_skillqueue.v1',
		'skills-read' => 'esi-skills.read_skills.v1',
		'ui-open' => 'esi-ui.open_window.v1',
		'ui-waypoint-write' => 'esi-ui.write_waypoint.v1',
		'universe-read-structures' => 'esi-universe.read_structures.v1',
		'wallet-read' => 'esi-wallet.read_character_wallet.v1'
	);
	
	const SESSION_TOKEN = 'token';
	
	const SESSION_REFRESH_TOKEN = 'refresh_token';
	
	const SESSION_TOKEN_EXPIRE = 'token_expiration';
	
	protected $config;
	
	protected $client;
	
	protected $session;
	
	protected $cache;
	
	protected $current_token;
	
	protected $session_expire;
	
	protected $refresh_token;
	
	protected $authorized = false;
	
	/*
	*	Initializes the Manager Object
	*
	*	@param array $config
	*	@return void
	*/
	public function __construct(array $config)
	{
		$this->config = $config;
		$this->client = new Client(['base_uri' => 'https://esi.tech.ccp.is/latest/']);
		$this->session = new $this->config['Session']['Handler']($this->config['Session']);
	}
	
	/*
	*	Returns array of available scopes
	*
	*	@return array
	*/
	public static function scopes()
	{
		return array_keys(self::AVAILABLE_SCOPES);
	}
	
	/*
	*	Checks for a valid token in session store and redirects to SSO if none is found or uses the supplied refresh token
	*
	*	@param string $refresh
	*	@return 
	*	@throws 
	*/
	public function authorize($refresh = NULL)
	{
		//	if a refresh token was given, try a refresh
		if($refresh !== NULL)
		{
			$this->refresh_token = $refresh;
			try{
				$this->refresh();
				$this->authorized = true;
				return true;
			} catch(Exception $e) {
				
			}
		}
		//	if it fails, try to check the session for a token
		try{
			$this->checkSession();			
		} catch(Exception $e) {
			//	if that fails, redirect to SSO for fresh session
			$this->redirect();
		}
	}
	
	/*
	*	Redirects to SSO with either default scopes or those manually defined
	*
	*
	*/
	public function redirect(array $scopes = NULL)
	{
		if($scopes === NULL)
			$scopes = $this->config['Manager']['default_scopes'];
		$url = self::SSO_URL.'/'.http_build_query(array(
			'response_type' => 'code',
			'redirect_uri' => $this->config['Manager']['callback_url'],
			'client_id' => $this->config['Manager']['client_id'],
			'scope' => implode(' ', $scopes),
			'state' => ''
		), NULL, NULL, PHP_QUERY_RFC3986);
		header('Location: ');
		exit;
	}
	
	/*
	*	Verify an Authorization Code received from the SSO
	*
	*
	*/
	public function verify($auth_code)
	{
		$response = $this->client->request('POST', self::AUTH_URL, [
			'headers' => [
				'Authorization' => 'Basic '.$this->buildBasicToken(),
				'Host' => 'login.eveonline.com'
			],
			'json' => [
				'grant_type' => 'authorization_code',
				'code' => $auth_code
			]
		]);
	}
	
	/*
	*	Checks session storage for valid credentials
	*
	*
	*/
	private function checkSession()
	{
		//	check for data in session
		if(isset($this->session->{self::SESSION_TOKEN}))
		{
			//	check that token is valid
			if($this->session->{self::SESSION_TOKEN_EXPIRE} < time())
			{
				$this->current_token = $this->session->{self::SESSION_TOKEN};
				$this->session_expire = $this->session->{self::SESSION_TOKEN_EXPIRE};
				$this->refresh_token = $this->session->{self::SESSION_REFRESH_TOKEN};
				return true;
			}
			//	if not, refresh it
			elseif(isset($this->session->{self::SESSION_REFRESH_TOKEN}))
				return $this->refresh();
		}
		return false;
	}
	
	/*
	*
	*
	*
	*/
	private function refresh()
	{
		$response = $this->client->request('POST', self::AUTH_URL, [
			'headers' => [
				'Authorization' => 'Basic '.$this->buildBasicToken(),
				'Host' => 'login.eveonline.com'
			],
			'json' => [
				'grant_type' => 'refresh_token',
				'refresh_token' => $this->refresh_token
			]
		]);
		$response = json_decode((string)$response, true);
		if(!isset($response['access_token']))
		{
			throw new Exception('');
		}
		$this->setCurrentToken($response['access_token']);
		$this->setRefreshToken($response['refresh_token']);
		$this->setExpiration(time() + $response['expires_in']);
	}
	
	/*
	*
	*
	*
	*/
	private function setExpiration($timestamp)
	{
		$this->session_expire = $timestamp;
		$this->session->{self::SESSION_TOKEN_EXPIRE} = $timestamp;
	}
	
	/*
	*
	*
	*
	*/
	private function setCurrentToken($token)
	{
		$this->current_token = $token;
		$this->session->{self::SESSION_TOKEN} = $token;
	}
	
	/*
	*
	*
	*
	*/
	private function setRefreshToken($token)
	{
		$this->refresh_token = $token;
		$this->session->{self::SESSION_REFRESH_TOKEN} = $token;
	}
	
	/*
	*
	*
	*
	*/
	private function buildBasicToken()
	{
		return base64_encode($this->config['Manager']['client_id'].':'.$this->config['Manager']['secret_key']);
	}
}