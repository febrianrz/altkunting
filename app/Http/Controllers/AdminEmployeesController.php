<?php namespace App\Http\Controllers;

use crocodicstudio\crudbooster\controllers\CBController;

class AdminEmployeesController extends CBController {


    public function cbInit()
    {
        $this->setTable("employees");
        $this->setPermalink("employees");
        $this->setPageTitle("Employees");

        $this->addText("Kode","kode")->strLimit(150)->maxLength(255);
		$this->addText("Nama","nama")->strLimit(150)->maxLength(255);
		$this->addEmail("Email","email");
		$this->addText("Keterangan","keterangan")->strLimit(150)->maxLength(255);
		$this->addDatetime("Created At","created_at")->required(false)->showAdd(false)->showEdit(false);
		$this->addDatetime("Updated At","updated_at")->required(false)->showAdd(false)->showEdit(false);
		

    }
}
