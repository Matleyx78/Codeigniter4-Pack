@php
namespace {namespace}\Controllers;

use CodeIgniter\Controller;
use {namespace}\Models\{! nameModel !};

{! modeluse !}

class {! nameController !} extends Controller
{
protected ${! table_lc !};
{! modelprotected !}
/**
* {! nameController !} constructor.
*/
public function __construct()
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

$this->{! table_lc !} = new {! nameModel !}();
{! modelconstruct !}
//if (session()->get('role') != "{! routegroup !}") {
// echo 'Access denied';
// exit;
//}
}

public function index()
{
${! table !} = $this->{! table_lc !}->findAll();
return view('{! views_path !}/index', [
'{! table !}' => ${! table !}
]);
}

public function add()
{
$data = array();
{! modeldatajoin !}

return view('{! views_path !}/add', $data);
}

public function save()
{
{! modeldatajoin !}

{! fieldsGet !}

$insert_data = [
{! fieldsData !}
];
if ($this->{! table_lc !}->save($insert_data) == false) {
$data['errors'] = $this->{! table_lc !}->errors();
return view('{! views_path !}/add', $data);
} else {
return redirect('{! table !}');
}
}

public function edit($id)
{
{! modeldatajoin !}

${! table_lc !} = $this->{! table_lc !}->find($id);
$data['value'] = ${! table_lc !};
return view('{! views_path !}/edit', $data);
}

public function update()
{
$id = $this->request->getPost('{! primaryKey !}');
{! fieldsGet !}

$insert_data = [
{! fieldsData !}
];
$this->{! table_lc !}->update($id, $insert_data);
return redirect('{! table !}');
}

public function delete($id)
{
$this->{! table_lc !}->delete($id);
return redirect('{! table !}');
}
}