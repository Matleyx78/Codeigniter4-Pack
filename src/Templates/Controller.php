@php
namespace {namespace}\Controllers;

use {! bc_path !}\BaseController;
use {namespace}\Models\{! nameModel !};

use stdClass;

{! modeluse !}

class {! nameController !} extends BaseController
{
protected $model_{! table_lc !};
{! modelprotected !}
/**
* {! nameController !} constructor.
*/
function __construct()
{
// if (auth()->loggedIn()) {
// $user = auth()->user();
// if (! $user->inGroup('xxx')) {
// echo 'Access denied';
// exit;
// }
// }else{
// echo 'Access denied';
// exit;
// }

$this->model_{! table_lc !} = new {! nameModel !}();
{! modelconstruct !}
//if (session()->get('role') != "{! routegroup !}") {
// echo 'Access denied';
// exit;
//}
}

function index()
{
$result = $this->model_{! table_lc !}->fetch_{!pluralRecord!}(10);
$data['pager'] = $result['pager'];
$data['{! table !}'] = $result['{! table !}'];
return view('{! views_path !}\index', $data);
}
function list_all()
{
$data['{! table !}'] = $this->model_{! table_lc !}->findAll();
return view('{! views_path !}\index', $data);
}
function add()
{
$data = array();
{! modeldatajoin !}
return view('{! views_path !}\add', $data);
}
function save()
{
$validation = service('validation');
$rules = [
{! fieldsVal !}
];
$validation->setRules($rules);
if ($validation->run($this->request->getPost())) {
$insert_data = new stdClass();
{! fieldsDataC !}

if ($this->model_{! table_lc !}->insert($insert_data) == false) {
$data['errors'] = $this->model_{! table_lc !}->errors();
return view('{! views_path !}\add', $data);
} else {
session()->setFlashdata('flashSuccess', 'Perfetto');
return redirect('{! table !}');
}
}else {
session()->setFlashdata('flashError', 'Error');
return redirect('{! table !}');
}
}

function edit($id)
{
{! modeldatajoin !}

${! table_lc !} = $this->model_{! table_lc !}->find($id);
$data['value'] = ${! table_lc !};
return view('{! views_path !}\edit', $data);
}

function update()
{
$id = $this->request->getPost('{! primaryKey !}');
$validation = service('validation');
$rules = [
{! fieldsVal !}
];
$validation->setRules($rules);
if ($validation->run($this->request->getPost())) {
$insert_data = new stdClass();
{! fieldsDataC !}

if ($this->model_{! table_lc !}->update($id, $insert_data) == false) {
$data['errors'] = $this->model_{! table_lc !}->errors();
return view('{! views_path !}\edit', $data);
} else {
session()->setFlashdata('flashSuccess', 'Perfetto');
return redirect('{! table !}');
}
}
session()->setFlashdata('flashError', 'Error');
return redirect('{! table !}');
}

function Xdelete($id)
{
$this->model_{! table_lc !}->delete($id);
return redirect('{! table !}');
}
}