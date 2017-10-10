<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sncf_example extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
	    $this->load->view('sncf/search');
	}
	
	
	/**
	 * Recherche un vol en fonction du n° de vol et de la date de départ
	 */
	public function search()
	{
	    
	    $this->form_validation->set_rules('trainNumber', 'Train number', 'trim|required|numeric');
	    $this->form_validation->set_rules('departureDate', 'Departure date', 'trim|required|numeric');
	    if (!$this->form_validation->run()) {
	        $this->load->view('sncf/search');
	        return;
	    }

	    $vTrainNumber = $this->input->post('trainNumber');
	    $vDate = DateTime::createFromFormat('Ymd', $this->input->post('departureDate'));
	    
	    $this->load->library('sncf');
	    
	    $trajet = $this->sncf->getTrajet($vTrainNumber, $vDate);
	    
	    //return $trajet->stop_times;
	    /*
	    if ($trajet) {
    	    $reponse = [
    	        'success' => true,
    	        'trajet' => $trajet,
    	    ];
	    } else {
    	    $reponse = [
    	        'success' => false,
    	        'error_msg' => 'Désolé, nous n\'avons pas trouvé votre numéro de vol ou de train à la date demandée.<br>Assurez vous d\'avoir renseigné correctement votre numéro ainsi que votre date de départ.',
    	    ];
	    }
	    
	    echo json_encode($reponse);
	    */
	    //var_dump($trajet);
	    
	    //var_dump($trajet->table->rows[0]);
	    /*
	    echo 'Train n° ' . $vTrainNumber;
	    echo 'Date de circulation : ' . $vDate->format(DateTime::ATOM);
	    $trajet = $trajet->table->rows;
	    echo '<table>';
	    //for (var row of pTrajet.rows) {
	    $html = '';
	    foreach($trajet as $row) {
	        $html .= '<tr>'
	            . 		'<td>'.$row->stop_point->name.'</td>';
	           
	            //foreach ($row->date_times as $dateTime) {
	                $vDateTime = new DateTime($row->date_times[0]->date_time);
	                $html .= '<td>';
	                //$html .= dateTime->date_time ? moment(dateTime.date_time).format('H:m') : '';
	                $html .= $vDateTime->format('H:i');
	                $html .= '</td>';
	            //}
	            //$html .= '<td>'.$row->date_times[0]->date_time.'</td>';
	            $html .= '</tr>';
	    }
	    $html .='</table>';
	    echo $html;
	    */
	    $datas = [
	        'trainNumber' => $vTrainNumber,
	        'dateCirculation' => $vDate,
	    ];
	    if ($trajet) {
	        $datas['trajet'] = $trajet->stop_times;
	    } else {
	        $datas['error'] = 'Your trip doesn\'t exist !';
	    }
	    
	    $this->load->view('sncf/search', $datas);
	    
	}
	
	
	
    private function searchTrain($noTrajet, DateTime $pDateDeparture)
    {
        $this->load->library('sncf');
        
        /*
        $id = $this->sncf->getTrainIdByNumber($noTrajet);
        //$id = $this->sncf->getTripIdByHeadsign($noTrajet);
        if (!$id) {
            return false;
        }
        
        $trajet = $this->sncf->getTrajetByIdAndDepartureDate($id, $pDateDeparture);
        */
        $trajet = $this->sncf->getTrajet($noTrajet, $pDateDeparture);
        
        return $trajet->stop_times;
        /*
        if ($trajet) {
            $vVol = [
                'type' => 'train',
                'description' => [
                    'rows' => $trajet->table->rows,
                    //'id' => $trajet->getId(),
                    //'threadId' => $trajet->departureAirportFsCode . $trajet->arrivalAirportFsCode . $trajet->getDepartureTime()->format('YmdHms'),
                    'equipment' => $trajet->display_informations->commercial_mode,     //'equipment' => $trajet->flightEquipment->getName(),
                ],
                //'id' => $id,
                'threadId' => $id . $pDateDeparture->format('Ymd'),
            ];
            return $vVol;
        }
        
        return false;
        */
    }
    
    
    
}
