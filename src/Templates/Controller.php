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
$data['{! table !}'] = $this->model_{! table_lc !}->findAll();
return view('{! views_path !}/index', $data);
}

function add()
{
$data = array();
{! modeldatajoin !}

return view('{! views_path !}/add', $data);
}

function save()
{
{! modeldatajoin !}

{! fieldsGet !}

$insert_data = new stdClass();
{! fieldsData !}

if ($this->model_{! table_lc !}->save($insert_data) == false) {
$data['errors'] = $this->model_{! table_lc !}->errors();
return view('{! views_path !}/add', $data);
} else {
return redirect('{! table !}');
}
}

function edit($id)
{
{! modeldatajoin !}

${! table_lc !} = $this->model_{! table_lc !}->find($id);
$data['value'] = ${! table_lc !};
return view('{! views_path !}/edit', $data);
}

function update()
{
$id = $this->request->getPost('{! primaryKey !}');
{! fieldsGet !}

$insert_data = new stdClass();
{! fieldsData !}

$this->model_{! table_lc !}->update($id, $insert_data);
return redirect('{! table !}');
}

function delete($id)
{
$this->model_{! table_lc !}->delete($id);
return redirect('{! table !}');
}
}