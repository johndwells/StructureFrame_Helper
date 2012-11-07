<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name' => 'Structureframe Helper',
  'pi_version' =>'1.1.0',
  'pi_author' =>'John D Wells',
  'pi_author_url' => 'https://github.com/johndwells/StructureFrame_Helper',
  'pi_description' => 'Structureframe Helper - Reverse Engineer a Structure Page URL to obtain additional info about the page.'
  );

class Structureframe_helper {

	private		$EE;
	public		$return_data;
	protected	$sql = FALSE; // instance of Sql_structure, if exists

	// ------------------------------

	/**
	 * Constructor
	 */
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
		}

		// begin by setting return_data to our URL (wherever it comes from)
		$this->return_data = $this->EE->TMPL->fetch_param('url', $url);

		// we need Sql_structure to proceed
		if($this->sql == FALSE) return $this->return_data;

		// reduce to URI
		$uri = str_replace(trim($this->EE->functions->fetch_site_index(0, 0), '/'), '', $this->return_data);
		
		// do the rest
		return $this->_return_data($uri);
	}

	// ------------------------------
	
	/**
	 * Our internal function to set $return_data property
	*/
	protected function _return_data($uri)
	{
		// what do we want to return (title is default)?
		$return = $this->EE->TMPL->fetch_param('return', 'title');

		// get our pages into an array we can work with
		$site_pages = $this->sql->get_site_pages();
		$uris = array_flip($site_pages['uris']);
		
		// got uri?
		if(array_key_exists($uri, $uris))
		{
			switch($return)
			{
				case 'id' :
					$this->return_data = $uris[$uri];
				break;

				case 'uri' :
					$this->return_data = $uri;
				break;

				case 'title' :
				default :
					$this->return_data = $this->sql->get_page_title($uris[$uri]);
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
