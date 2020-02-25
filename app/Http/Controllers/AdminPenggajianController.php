<?php namespace App\Http\Controllers;

use App\Payroll;
use crocodicstudio\crudbooster\helpers\MailHelper;
use crocodicstudio\crudbooster\controllers\CBController;

class AdminPenggajianController extends CBController {


    public function cbInit()
    {
        $this->setTable("payrolls");
        $this->setPermalink("penggajian");
        $this->setPageTitle("Penggajian");

        $this->addSelectTable("Employee","employee_id",["table"=>"employees","value_option"=>"id","display_option"=>"nama","sql_condition"=>null]);
		$this->addText("Title","title")->strLimit(150)->maxLength(255);
		$this->addMoney("Nominal","nominal")->prefix('IDR');
		$this->addWysiwyg("Rincian","rincian")->strLimit(5000)->showIndex(false);
		$this->addText("Keterangan","keterangan")->showIndex(false)->required(false)->strLimit(150)->maxLength(255);
		$this->addImage("Bukti Transfer","bukti_transfer")->encrypt(true);
		$this->addDatetime("Created At","created_at")->required(false)->showAdd(false)->showEdit(false);
		$this->addDatetime("Updated At","updated_at")->required(false)->showAdd(false)->showEdit(false);
        
        $this->hookAfterInsert(function($last_insert_id) {
            // Todo: code here
            try {
                $payroll = Payroll::find($last_insert_id);
                $mail = new MailHelper();
    
                // First param is for send mail address, second param is for sender name
                $mail->sender("febrianrz@alterindonesia.com", "Finance Alter Indonesia");
    
                $mail->to($payroll->employee->email,"febrianrz@gmail.com");
                $mail->subject($payroll->title);
    
                $html = "Assalamualaikum Warohmatullahi Wabarakatuh, <br><br> Hi {$payroll->employee->nama}, berikut adalah rincian payroll untuk bulan ini ya: <br>".$payroll->rincian;
                $html .= "<br>Terlampir bukti transfernya<br><br>Jika terdapat kesalahan, silahkan membalas email ini, semoga Alter Indonesia bisa memberikan lebih lagi dibulan bulan selanjutnya, 
                    mohon kerja samanya teman-teman, terima kasih <br>Salam hangat<br>--Alter Indonesia--<br>";
                    // dd($html);
                $mail->content($html);
    
                // If you want to attach the file, add this bellow method
                $mail->addAttachment(($payroll->bukti_transfer));
    
                // Send email
                $mail->send();
            } catch(\Exception $e){
                dd($e->getMessage());
            }
        });
    
    

    }
}
