<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use PDF;
use quickchart;

class EmployeeController extends Controller {

    // Display user data in view
    public function index(){
      $employee = Employee::all();
      return view('index', compact('employee'));
    }

    // Generate PDF
    public function createPDF() {
      // retreive all records from db
       $data['employee'] = Employee::all();

       $qc = new QuickChart(array(
          'width' => 600,
          'height' => 300,
        ));

        $qc->setConfig('{
          type: "pie",   // line , radar, pie , doughnut , bar
          data: {
            labels: ["January","February","March","April","May" ],
            datasets: [{
              label: "Dogs",
              data: [50,60,70,180,190]
            }, 
            {
                label: "Cats",
                data:[100,200,300,400,500]
            }
            ]
          }
        }');

        // Print the chart URL
        $data['chart'] = $qc->getShortUrl(); // $qc->getUrl();
        

      // share data to view
      view()->share('employee',$data);
      $pdf = PDF::loadView('pdf_view', $data);

      // download PDF file with download method
      return $pdf->download('pdf_file.pdf');
    }
}