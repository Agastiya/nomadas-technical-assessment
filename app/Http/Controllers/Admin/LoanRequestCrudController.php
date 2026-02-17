<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LoanRequestRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class LoanRequestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LoanRequestCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\LoanRequest::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/loan-request');
        CRUD::setEntityNameStrings('loan request', 'loan requests');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {    
        CRUD::with('user');
        CRUD::addColumn([
            'name' => 'user.name',
            'type' => 'relationship',
            'attribute' => 'name',
            'label' => 'User',
        ]);
        CRUD::column('item_name');
        CRUD::addColumn([
            'name' => 'status',
            'type' => 'text',
            'label' => 'Status',
            'value' => function ($entry) {
                return ucfirst($entry->status);
            },
        ]);
        CRUD::column('loan_date');
        CRUD::column('return_date');

        CRUD::addButtonFromView('line', 'approve_modal', 'approve_modal', 'end');

        CRUD::orderButtons('line', ['approve_modal', 'show', 'update', 'delete']);
    }

    protected function setupShowOperation()
    {
        $this->crud->setShowView('admin.loanRequest.show');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(LoanRequestRequest::class);
        CRUD::field('item_name');
        CRUD::field('loan_date')->type('date');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    // public function show($id)
    // {
    //     dd($id);
    // }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');
        $request = $this->crud->validateRequest();
        
        $data = $request->validated();
        $data['user_id'] = backpack_user()->id;
        $data['item_name'] = $request->input('item_name');
        $data['loan_date'] = $request->input('loan_date');

        $item = $this->crud->create($data);

        return $this->crud->performSaveAction($item->getKey());
    }

    public function processRequest(Request $request, $id)
    {
        $entry = $this->crud->getEntry($id);
        $entry->status = $request->input('status');
        $entry->reason = $request->input('reject_reason');
        $entry->save();

        return response()->json(['success' => true]);
    }
}
