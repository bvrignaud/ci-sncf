<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Doctrine\Common\Annotations\AnnotationRegistry;
use Navitia\Component\Service\ServiceFacade;


/**
 * Sncf library for CodeIgniter.
 *
 * @author Benoit VRIGNAUD <benoit.vrignaud@zaclys.net>
 *
 */
class Sncf
{
    /** @var CI_Controller */
    private $ci;
    
    /** @var ServiceFacade */
    private $client;
    
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->config('sncf', TRUE);
		
		// Configuration
		$config = array(
		    'url' => $this->ci->config->item('url', 'sncf'),
		    'token' => $this->ci->config->item('token', 'sncf'),
		);
		$this->client = ServiceFacade::getInstance(new \Psr\Log\NullLogger());
		$this->client->setConfiguration($config);
		
		// must be called to register Doctrine annotations
		AnnotationRegistry::registerLoader('class_exists');
	}
	
	
	/**
	 * Récupère un trajet en fonction de son n° commercial et sa date de départ.
	 * @param string $pTrainNumber - ex: 3615
	 * @param DateTime $pDate
	 * @return null|stdClass
	 */
	public function getTrajet($pTrainNumber, DateTime $pDate)
	{
	    $vStartDate = $pDate->format('Ymd');
	    $vDateEnd = DateTime::createFromFormat('Ymd', $vStartDate);
	    $vDateEnd->add(new DateInterval('P1D'));
	    $vEndDate = $vDateEnd->format('Ymd');
	    $query = array(
	        'api' => 'coverage',
	        'parameters' => array(
	            'region' => 'sncf',
	            'path_filter' => "vehicle_journeys?headsign=$pTrainNumber&since=$vStartDate&until=$vEndDate",
	        ),
	    );
	    $result = $this->client->call($query);
	    
	    if (!isset($result->vehicle_journeys)) {
	        return null;
	    }
	    
	    return $result->vehicle_journeys[0];
	}
	
}
