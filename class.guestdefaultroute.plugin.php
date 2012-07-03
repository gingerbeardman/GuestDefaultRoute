<?php if (!defined('APPLICATION')) exit();

// Define the plugin:
$PluginInfo['GuestDefaultRoute'] = array(
	'Name' => 'Guest Default Route',
	'Description' => 'In settings you can set a route for your homepage (effectively the default controller/view) this plugin allows a different route for guests.',
	'Version' 	=>	 '1.0.0',
	'Author' 	=>	 "Matt Sephton",
	'AuthorEmail' => 'matt@gingerbeardman.com',
	'AuthorUrl' =>	 'http://www.vanillaforums.org/profile/matt',
	'License' => 'GPL v2',
	'SettingsUrl' => '/settings/guestdefaultroute',
	'SettingsPermission' => 'Garden.Settings.Manage',
	'RequiredApplications' => array('Vanilla' => '>=2'),
);

/*
* # Guest Default Route #
* 
* ### About ###
* In settings you can set a route for your homepage
* (effectively the default controller/view)
* this plugin allows a different route for guests.
* 
* ### Thanks to ###
* http://vanillaforums.org/addon/mobiledefaultroute-plugin
* http://vanillaforums.org/discussion/comment/154971/
*/

class GuestDefaultRoute extends Gdn_Plugin {

	public function SettingsController_GuestDefaultRoute_Create($Sender, $Args = array()) {
		$Sender->Permission('Garden.Settings.Manage');
		$Sender->SetData('Title', T('Guest Default Route'));

		$Cf = new ConfigurationModule($Sender);
		$Cf->Initialize(array(
			'Plugins.GuestDefaultRoute.Destination' => array('Description' => 'The default route for guests (leave blank to disable)', 'Control' => 'TextBox')
		));

		$Sender->AddSideMenu('dashboard/settings/plugins');
		$Cf->RenderAll();
	}
	
	public function Base_BeforeDispatch_Handler($Sender,&$Args){
		if(!((Gdn::Session()->IsValid() == 0) && C('Plugins.GuestDefaultRoute.Destination'))) return;
		
		$Routes=&Gdn::Router()->Routes;
		if(GetValue('DefaultController',$Routes))
			$Routes['DefaultController']['Destination']=C('Plugins.GuestDefaultRoute.Destination');
	}
	
}
?>