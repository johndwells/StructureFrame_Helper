<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name' => 'Structureframe Helper',
  'pi_version' =>'1.0.0',
  'pi_author' =>'John D Wells',
  'pi_author_url' => 'https://github.com/johndwells/StructureFrame_Helper',
  'pi_description' => 'Structureframe Helper - Reverse Engineer a Structure Page URL to obtain additional info about the page.'
  );

class Structureframe_helper {

	private $EE;
	public $return_data;

	protected $sql = FALSE;
	

	function __construct($url = '')
	{
		$this->EE =& get_instance();

		if( ! class_exists('Sql_structure'))
		{
			include PATH_THIRD.'structure/sql.structure.php';
		}

		if(class_exists('Sql_structure'))
		{
			$this->sql = new Sql_structure();
			$site_pages = $this->sql->get_site_pages();
		}

		// fetch param(s)
		$url = $this->EE->TMPL->fetch_param('url', $url);
		$return = $this->EE->TMPL->fetch_param('return', 'title');

		// sanitise $return
		$return = (preg_match('/title|id/i', $return)) ? $return : 'title';

		// we need Sql_structure & a URL to proceed
		if($this->sql == FALSE || !$url) return;

		// begin by setting return_data to our URL
		$this->return_data = $url;

		// reduce to URI
		$uri = str_replace(trim($this->EE->functions->fetch_site_index(0, 0), '/'), '', $url);

		// seek out page
		foreach($site_pages['uris'] as $i => $u)
		{
			// found it?!
			if($u == $uri)
			{
				// determine what to return
				switch($return)
				{
					case 'id' :
						$this->return_data = $i;
					break;

					case 'title' :
					default :
						$this->return_data = $this->sql->get_page_title($i);
					break;
				}

				// abort remainder of foreach
				break;
			}
		}

		// laters
		return $this->return_data;
	}
	// ------------------------------
}	
/* End of file pi.structureframe_helper.php */ 
/* Location: ./system/expressionengine/third_party/structureframe_helper/pi.structureframe_helper.php */
