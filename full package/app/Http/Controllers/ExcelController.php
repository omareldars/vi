<?php
namespace App\Http\Controllers;
use App\Cycle;
use App\Event;
use App\EventsUser;
use App\Formdata;
use App\MentorshipRequest;
use App\Service;
use App\Step;
use App\User;
use App\Settings;
use App\Company;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Illuminate\Support\Facades\Auth;
/// Excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require '../vendor/autoload.php';

class ExcelController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }
  public function ExUsers(Request $request)
  {
      $this->preProcessingCheck('view_report');
      $gender = request()->input('gender');
      $types=$request->type;
      $setting = Settings::findorfail('1'); // Get Title
      if ($types)
        {
            $users = User::leftJoin('states', 'state_id', 'states.id')->LeftJoin('model_has_roles', 'users.id', 'model_id')->whereIn('role_id', array_values($types));
        }
            else
        {
            $users = User::leftJoin('states','state_id','states.id')->LeftJoin('model_has_roles', 'users.id', 'model_id'); // Get all Users
        }
      if (isset($gender))
      {
          $users = $users->where('gender',$gender);
      }
    $users = $users->get();
	$num=1;$row=4;
if($request->details) { /// details file
    $list = ['','Admin','Editor','Coordinator','Page Manager','Manager','Mentor','Judger','Registered','Pages Editor'];
    request()->input('lang')=='ar' ? $l = 'ar' : $l = 'en';
    if ($l=='ar') {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/UsersDetailsAr.xlsx"); } else {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/UsersDetailsEn.xlsx");
    }
        $sheet = $spreadsheet->getActiveSheet();
        $l == 'ar' ? $ttitle = 'تقرير بيانات المستخدمين': $ttitle = 'Users data report';
        $sheet->setCellValue('K1', $setting->{$l=='ar'?'ar_title':'title'});
        $sheet->setCellValue('A2', $ttitle.' (' . Date('M-Y') . ')');
        // Fill users
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $num);
            $sheet->setCellValue('B' . $row, $user->{'first_name_'.$l} );
            $sheet->setCellValue('C' . $row, $user->{'last_name_'.$l} );
            $user->gender == 'Male'?$gender = 'ذكر':$gender = 'أنثى';
            if($l =='en'){$gender=$user->gender;}
            $sheet->setCellValue('D' . $row, $gender);
            $sheet->setCellValue('E' . $row, $user->phone);
            $sheet->setCellValue('F' . $row, $user->email);
            $sheet->setCellValue('G' . $row, $user->{'title_'.$l} );
            $sheet->setCellValue('H' . $row, $user->state->{'name_'.$l} ?? '-');
            $sheet->setCellValue('I' . $row, $user->city->{'name_'.$l} ?? '-');
            $sheet->setCellValue('J' . $row, $user->company->{'name_'.$l} ?? '-');
            $sheet->setCellValue('K' . $row, $list[$user->role_id] ?? 'No roles');
            $row++;
            $num++;
        }
    // Set Style
    $row--;
    $sheet->getStyle('A4:K'.$row)->getBorders()->applyFromArray(['allBorders'=>['borderStyle'=>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color'=>['rgb'=>'000000']]]);

} else {
if (request()->input('lang')=='ar') {
// Load Excel template
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/UsersAr.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
// Set Title
    $sheet->setCellValue('F1', $setting->ar_title);
    $sheet->setCellValue('A2', 'تقرير بيانات المستخدمين (' . Date('M-Y') . ')');
// Fill users
    foreach ($users as $user) {
        $sheet->setCellValue('A' . $row, $num);
        $sheet->setCellValue('B' . $row, $user->first_name_ar . ' ' . $user->last_name_ar);
        $gender = 'أنثى';
        if ($user->gender == 'Male') {
            $gender = 'ذكر';
        }
        $sheet->setCellValue('C' . $row, $gender);
        $sheet->setCellValue('D' . $row, $user->name_ar);
        $sheet->setCellValue('E' . $row, $user->phone);
        $sheet->setCellValue('F' . $row, $user->email);
        $row++;
        $num++;
    }
}
else {
// Load Excel template
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/UsersEn.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
// Set Title
    $sheet->setCellValue('F1', $setting->title);
    $sheet->setCellValue('A2', 'Registered Users Report (' . Date('M-Y') . ')');
// Fill users
    foreach ($users as $user) {
        $sheet->setCellValue('A' . $row, $num);
        $sheet->setCellValue('B' . $row, $user->first_name_en . ' ' . $user->last_name_en);
        $sheet->setCellValue('C' . $row, $user->gender);
        $sheet->setCellValue('D' . $row, $user->name_en);
        $sheet->setCellValue('E' . $row, $user->phone);
        $sheet->setCellValue('F' . $row, $user->email);
        $row++;
        $num++;
    }
}
// Set Style
	$row--;
	$sheet->getStyle('A4:F'.$row)->getBorders()->applyFromArray(['allBorders'=>['borderStyle'=>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color'=>['rgb'=>'000000']]]);
} /// end of formatted file
	// Set File Name
	$downloaded=str_replace(' ', '','RegisteredUsers').'-'.Date('M-Y').'.xlsx';
	// Saving the document as Excel file...
	$temp_file = tempnam(sys_get_temp_dir(), 'spreadsheet');
	$objWriter = new Xlsx($spreadsheet);
	$objWriter->save('tmp/'.$downloaded);
	unlink($temp_file);
	ob_end_clean();
return response()->download(public_path() . '/tmp/' . urldecode($downloaded))->deleteFileAfterSend(true);
    }

// Companies Report
    public function ExCompanies(Request $request)
    {
        $this->preProcessingCheck('view_report');
        $states = request()->input('state');
        $type = request()->input('type');
        if (!isset($states)) {$states=[];}
        $setting = Settings::findorfail('1'); // Get Title
        if (count($states) > 0)
        {
            $companies = Company::whereIn('state_id',array_values($states));
        }
        else
        {
            $companies = Company::whereNotNull('id'); // Get all
        }
        if (isset($type))
        {
            if ($type=='new') {
                $companies = $companies->whereNull('cycle');
            } elseif ($type=='cycle') {
                $companies = $companies->whereNotNull('cycle');
            } elseif ($type=='approved') {
                $companies = $companies->whereNotNull('approved');
            }
        }
        $companies = $companies->get();
        $num=1;$row=4;
        request()->input('lang')=='ar'?$l='ar':$l='en';
        $l == 'ar' ? $ctitle = "تقرير بيانات الشركات" : $ctitle = "Registered Companies Report";
        if($request->details) { /// details file
// Load Excel template
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/CompaniesDetails_" . $l . ".xlsx");
            $sheet = $spreadsheet->getActiveSheet();
            // Set Title
            $sheet->setCellValue('Z1', $setting->{$l=='ar'?'ar_title':'title'});
            $sheet->setCellValue('A2', $ctitle . ' (' . Date('M-Y') . ')');
            // Fill
            foreach ($companies as $company) {
                $sheet->setCellValue('A' . $row, $num);
                $sheet->setCellValue('B' . $row, $company->{'name_' . $l});
                $sheet->setCellValue('C' . $row, $company->state->{'name_' . $l});
                $sheet->setCellValue('D' . $row, $company->city->{'name_' . $l});
                $sheet->setCellValue('E' . $row, $company->phone);
                $sheet->setCellValue('F' . $row, $company->email);
                $sheet->setCellValue('G' . $row, $company->sector);
                $sheet->setCellValue('H' . $row, $company->{'address_'.$l});
                $sheet->setCellValue('I' . $row, $company->est_date);
                $sheet->setCellValue('J' . $row, $company->idea);
                $sheet->setCellValue('K' . $row, $company->problem);
                $sheet->setCellValue('L' . $row, $company->solution);
                $sheet->setCellValue('M' . $row, $company->team_num);
                $sheet->setCellValue('N' . $row, $company->stage);
                $sheet->setCellValue('O' . $row, $company->raised_fund);
                $sheet->setCellValue('P' . $row, $company->investors);
                $sheet->setCellValue('Q' . $row, $company->founder);
                $sheet->setCellValue('R' . $row, $company->employees);
                $sheet->setCellValue('S' . $row, $company->fax);
                $sheet->setCellValue('T' . $row, $company->website);
                $sheet->setCellValue('U' . $row, $company->facebook);
                $sheet->setCellValue('V' . $row, $company->twitter);
                $sheet->setCellValue('W' . $row, $company->linkedin);
                $sheet->setCellValue('X' . $row, $company->youtube);
                $sheet->setCellValue('Y' . $row, $company->cycledata->title ??'-');
                $sheet->setCellValue('Z' . $row, $company->stepdata->title??'-');
                $row++;
                $num++;
                }
            // Set Style
            $row--;
            $sheet->getStyle('A4:Z' . $row)->getBorders()->applyFromArray(['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]);

        } else {
// Load Excel template
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/Companies_" . $l . ".xlsx");
            $sheet = $spreadsheet->getActiveSheet();
// Set Title
            $sheet->setCellValue('F1', $setting->ar_title);
            $sheet->setCellValue('A2', $ctitle . ' (' . Date('M-Y') . ')');
// Fill
            foreach ($companies as $company) {
                $sheet->setCellValue('A' . $row, $num);
                $sheet->setCellValue('B' . $row, $company->{'name_' . $l});
                $sheet->setCellValue('C' . $row, $company->state->{'name_' . $l});
                $sheet->setCellValue('D' . $row, $company->city->{'name_' . $l});
                $sheet->setCellValue('E' . $row, $company->phone);
                $sheet->setCellValue('F' . $row, $company->email);
                $row++;
                $num++;
            }
// Set Style
            $row--;
            $sheet->getStyle('A4:F' . $row)->getBorders()->applyFromArray(['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]);
        } /// End create file
        // Set File Name
        $downloaded=str_replace(' ', '','Companies').'-'.Date('M-Y').'.xlsx';
        // Saving the document as Excel file...
        $temp_file = tempnam(sys_get_temp_dir(), 'spreadsheet');
        $objWriter = new Xlsx($spreadsheet);
        $objWriter->save('tmp/'.$downloaded);
        unlink($temp_file);
        ob_end_clean();
        return response()->download(public_path() . '/tmp/' . urldecode($downloaded))->deleteFileAfterSend(true);
    }

// Events report
    public function events($id)
    {
        if (!Auth::user()->hasAnyPermission(['manage_events', 'manage_csr_event'])) {return abort(401);}
        if (!isset($id)) {return abort(500);}
        $setting = Settings::findorfail('1');
        $users = EventsUser::where('event_id',$id)->get();
        if (count($users)==0) { return redirect()->back()->with('message2', 'nousers');}
        $event = Event::where('id',$id)->first('title_ar');
        $num=1;$row=4;
// Load Excel template
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/events.xlsx");
            $sheet = $spreadsheet->getActiveSheet();
// Set Title
            $sheet->setCellValue('F1', $setting->ar_title);
            $sheet->setCellValue('A2',  $event->title_ar.' (' . Date('M-Y') . ')');
// Fill users
            foreach ($users as $user) {
                $sheet->setCellValue('A' . $row, $num);
                $sheet->setCellValue('B' . $row, $user->name);
                $sheet->setCellValue('C' . $row, $user->email);
                $sheet->setCellValue('D' . $row, $user->phone);
                $sheet->setCellValue('E' . $row, $user->employer);
                $sheet->setCellValue('F' . $row, $user->jobtitle);
                $row++;
                $num++;
            }
// Set Style
        $row--;
        $sheet->getStyle('A4:F'.$row)->getBorders()->applyFromArray(['allBorders'=>['borderStyle'=>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color'=>['rgb'=>'000000']]]);
        // Set File Name
        $downloaded=str_replace(' ', '','Events').'-'.Date('M-Y').'.xlsx';
        // Saving the document as Excel file...
        $temp_file = tempnam(sys_get_temp_dir(), 'spreadsheet');
        $objWriter = new Xlsx($spreadsheet);
        $objWriter->save('tmp/'.$downloaded);
        unlink($temp_file);
        ob_end_clean();
        return response()->download(public_path() . '/tmp/' . urldecode($downloaded))->deleteFileAfterSend(true);
    }

    public function index()
    {
        return view('admin.reports.dashboard');
    }
    public function auditlog()
    {
        $this->preProcessingCheck('view_log');
// Load Excel template
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/AuditLog.xlsx");
            $sheet = $spreadsheet->getActiveSheet();
            $alllog = \App\AuditLog::all();
            $row = 4;
// Fill log
            foreach ($alllog as $log) {
                $sheet->setCellValue('A' . $row, $log->id);
                $sheet->setCellValue('B' . $row, $log->description);
                $sheet->setCellValue('C' . $row, $log->subject_id);
                $sheet->setCellValue('D' . $row, $log->subject_type);
                $sheet->setCellValue('E' . $row, $log->user_id);
                $sheet->setCellValue('F' . $row, $log->host);
                $sheet->setCellValue('G' . $row, $log->updated_at);
                $sheet->setCellValue('H' . $row, $log->properties);
                $row++;
            }
// Set Style
        $row--;
        $sheet->getStyle('A4:H'.$row)->getBorders()->applyFromArray(['allBorders'=>['borderStyle'=>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color'=>['rgb'=>'000000']]]);

        // Set File Name
        $downloaded=str_replace(' ', '','VI-LogBackup').'-'.Date('M-Y').'.xlsx';
        // Saving the document as Excel file...
        $temp_file = tempnam(sys_get_temp_dir(), 'spreadsheet');
        $objWriter = new Xlsx($spreadsheet);
        $objWriter->save('tmp/'.$downloaded);
        unlink($temp_file);
        ob_end_clean();
        return response()->download(public_path() . '/tmp/' . urldecode($downloaded))->deleteFileAfterSend(true);
    }
/// Services Report
    public function ExServices(Request $request)
    {
        $this->preProcessingCheck('view_report');
        $cat = request()->input('cat');
        if (!isset($cat)) {$cat=[];}
        $setting = Settings::findorfail('1'); // Get Title
        if (count($cat) > 0) {$services = Service::whereIn('service_category_id',array_values($cat));} else {$services = Service::whereNotNull('id');}
        $services = $services->get();
        $num=1;$row=4;
        request()->input('lang')=='ar'?$l='ar':$l='en';
        $l == 'ar' ? $ctitle = "تقرير بيانات الخدمات" : $ctitle = "Services Report";
// Load Excel template
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/Services_" . $l . ".xlsx");
            $sheet = $spreadsheet->getActiveSheet();
            // Set Title
            $sheet->setCellValue('F1', $setting->{$l=='ar'?'ar_title':'title'});
            $sheet->setCellValue('A2', $ctitle . ' (' . Date('M-Y') . ')');
            // Fill
            foreach ($services as $service) {
                $sheet->setCellValue('A' . $row, $num);
                $sheet->setCellValue('B' . $row, $service->{'name_' . $l});
                $sheet->setCellValue('C' . $row, $service->serviceCategory->{'name_' . $l});
                $sheet->setCellValue('D' . $row, $service->price);
                $sheet->setCellValue('E' . $row, $service->totalRequests());
                $sheet->setCellValue('F' . $row, $service->totalRate());
                $row++;$num++;
            }
        // Set Style
            $row--;
            $sheet->getStyle('A4:F' . $row)->getBorders()->applyFromArray(['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]);
        // Set File Name
        $downloaded=str_replace(' ', '','Services').'-'.Date('M-Y').'.xlsx';
        // Saving the document as Excel file...
        $temp_file = tempnam(sys_get_temp_dir(), 'spreadsheet');
        $objWriter = new Xlsx($spreadsheet);
        $objWriter->save('tmp/'.$downloaded);
        unlink($temp_file);
        ob_end_clean();
        return response()->download(public_path() . '/tmp/' . urldecode($downloaded))->deleteFileAfterSend(true);
    }
/// Mentors Report
    public function ExMentors(Request $request)
    {
        $this->preProcessingCheck('view_report');
        $sort = request()->input('sort');
        request()->input('lang')=='ar'?$l='ar':$l='en';
        $sort=='id'?$sort='id':$sort=$sort.'_'.$l;
        $setting = Settings::findorfail('1'); // Get Title
        $mentors = MentorshipRequest::join('users','mentor_id','users.id')->groupBy('mentor_id')->where('approved','Yes')->orderBy($sort,'ASC')
                    ->get(['users.id as id','first_name_'.$l,'last_name_'.$l,'title_'.$l,'email',DB::raw('count(*) as sessions'),DB::raw('avg(rating) as rating')]);
        $num=1;$row=4;
        $l == 'ar' ? $mtitle = "تقرير بيانات جلسات المرشدين" : $mtitle = "Mentorship sessions Report";
// Load Excel template
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/Mentors_" . $l . ".xlsx");
        $sheet = $spreadsheet->getActiveSheet();
        // Set Title
        $sheet->setCellValue('F1', $setting->{$l=='ar'?'ar_title':'title'});
        $sheet->setCellValue('A2', $mtitle . ' (' . Date('M-Y') . ')');
        // Fill
        foreach ($mentors as $ment) {
            $sheet->setCellValue('A' . $row, $num);
            $sheet->setCellValue('B' . $row, $ment->{'first_name_' . $l}.' '.$ment->{'last_name_' . $l});
            $sheet->setCellValue('C' . $row, $ment->{'title_' . $l});
            $sheet->setCellValue('D' . $row, $ment->email);
            $sheet->setCellValue('E' . $row, $ment->sessions);
            $sheet->setCellValue('F' . $row, $ment->rating);
            $row++;$num++;
        }
        // Set Style
        $row--;
        $sheet->getStyle('A4:F' . $row)->getBorders()->applyFromArray(['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]);
        // Set File Name
        $downloaded=str_replace(' ', '','Mentors').'-'.Date('M-Y').'.xlsx';
        // Saving the document as Excel file...
        $temp_file = tempnam(sys_get_temp_dir(), 'spreadsheet');
        $objWriter = new Xlsx($spreadsheet);
        $objWriter->save('tmp/'.$downloaded);
        unlink($temp_file);
        ob_end_clean();
        return response()->download(public_path() . '/tmp/' . urldecode($downloaded))->deleteFileAfterSend(true);
    }
    /// Screening Report
    public function ExScreening(Request $request)
    {
        $this->preProcessingCheck('view_report');
        request()->input('lang')=='ar'?$l='ar':$l='en';
        $setting = Settings::findorfail('1'); // Get Title
        $step = Step::findOrFail($request->step);
        $l == 'ar' ? $mtitle = "تقرير مدخلات الشركات بالدورة - ".$step->cycle->title.' - المرحلة '.$step->title : $mtitle = "Companies inputs Report - Cycle ".$step->cycle->title.' - Step '.$step->title ;
// Load Excel template
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("ExcelReports/Answers_" . $l . ".xlsx");
        $sheet = $spreadsheet->getActiveSheet();
        // Set Title

        $sheet->setCellValue('A2', $mtitle . ' (' . Date('M-Y') . ')');
        $titles = Formdata::where('form_id',$request->step)->groupBy('question')->orderBy('Field')->get([DB::raw('min(`field_id`) as Field , `question`')]);
        $c = 'A';$chars = array($c);$num=1;$col=2;
        while ($c < 'ZZ') $chars[] = ++$c;
        // Fill titles
        foreach ($titles as $title) {
            $sheet->setCellValue( $chars[$col] . '3', $title->question);
            // Fil answers
            $row = 4;$id = $title->Field;
            $results = Formdata::where('form_id',$request->step)->orderBy('company_id')->orderBy('field_id')->where('field_id',$id)->get();
            foreach ($results as $c) {
                if ($col==2)    {
                                $sheet->setCellValue( 'A' . $row,$num);
                                $sheet->setCellValue( 'B' . $row,$c->company()->{'name_'.$l});
                                $num++;
                    $sheet->getCell('B' . $row)
                        ->getHyperlink()
                        ->setUrl(env('APP_URL').'/admin/companyProfile/'. $c->company_id)
                        ->setTooltip('Click to open company details');
                    $sheet->getStyle('B' . $row)->applyFromArray(array( 'font' => array( 'color' => ['rgb' => '0000FF'], 'underline' => 'single' ) ));
                                }
                if ($c->answer && strpos($c->answer,"http")===0) {
                    $sheet->setCellValue( $chars[$col] . $row, 'Download');
                    $sheet->getCell($chars[$col] . $row)
                        ->getHyperlink()
                        ->setUrl($c->answer)
                        ->setTooltip('Click to open file');
                    $sheet->getStyle($chars[$col] . $row)->applyFromArray(array( 'font' => array( 'color' => ['rgb' => '0000FF'], 'underline' => 'single' ) ));
                } else {
                    $sheet->setCellValue( $chars[$col] . $row, $c->answer);
                }
                $row++;
            }
            $col++;
        }
        // Set Style
        $col--;$num=$num+2;
        $sheet->setCellValue($chars[$col].'1', $setting->{$l=='ar'?'ar_title':'title'});
        $sheet->getStyle('A3:'.$chars[$col]. $num)->getBorders()->applyFromArray(['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]);
        $sheet->mergeCells('A2:'.$chars[$col].'2');
        // Set File Name
        $downloaded=str_replace(' ', '','Screening').'-'.Date('M-Y').'.xlsx';
        // Saving the document as Excel file...
        $temp_file = tempnam(sys_get_temp_dir(), 'spreadsheet');
        $objWriter = new Xlsx($spreadsheet);
        $objWriter->save('tmp/'.$downloaded);
        unlink($temp_file);
        ob_end_clean();
        return response()->download(public_path() . '/tmp/' . urldecode($downloaded))->deleteFileAfterSend(true);
    }
}