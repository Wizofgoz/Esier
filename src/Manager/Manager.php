<?php
namespace Esir\Manager;
use \GuzzleHttp\Client;
class Manager
{
	const AUTH_URL = 'https://login.eveonline.com/oauth/authorize';
	
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
	
	protected $config;
	
	protected $client;
	
	protected $session;
	
	protected $cache;
	
	protected $current_token;
	
	protected $session_expire;
	
	public function __construct(array $config)
	{
		$this->config = $config;
		$this->client = new Client(['base_uri' => 'https://esi.tech.ccp.is/latest/']);
		$this->session = new $this->config['Session']['Handler']($this->config['Session']);
	}
	
	/*
	*	Checks for a valid token in session store and redirects to SSO if none is found
	*
	*
	*/
	private function boot()
	{
		
	}
}