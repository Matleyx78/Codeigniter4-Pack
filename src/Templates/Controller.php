@php
namespace {namespace}\Controllers;

use CodeIgniter\Controller;
use App\Models\{! nameModel !};

{! modeluse !}

class {! nameController !} extends Controller
{
    protected ${! singularTable !};
{! modelprotected !}
    /**
     * {! nameController !} constructor.
     */
    public function __construct()
    {
        $this->{! singularTable !} = new {! nameModel !}();
{! modelconstruct !}
        //if (session()->get('role') != "{! routegroup !}") {
        //    echo 'Access denied';
        //    exit;
        //}
    }

    public function index()
    {
        ${! table !} = $this->{! singularTable !}->findAll();
        return view('{! table !}/index', [
            '{! table !}' => ${! table !}
        ]);
    }

    public function add()
    {
        $data = array();
{! modeldatajoin !}
        
        return view('{! table !}/add', $data);
    }

    public function save()
    {
{! modeldatajoin !}

{! fieldsGet !}

        $insert_data = [
{! fieldsData !}
        ];
        if ($this->{! singularTable !}->save($insert_data) == false) {
            $data['errors'] = $this->{! singularTable !}->errors();
            return view('{! table !}/add', $data);
        } else {
            return redirect('{! table !}');
        }
    }

    public function edit($id)
    {
{! modeldatajoin !}

        ${! singularTable !} = $this->{! singularTable !}->find($id);
        $data['value'] = ${! singularTable !};
        return view('{! table !}/edit', $data);
    }

    public function update()
    {
            $id = $this->request->getPost('{! primaryKey !}');
{! fieldsGet !}

        $insert_data = [
{! fieldsData !}
        ];
        $this->{! singularTable !}->update($id, $insert_data);
        return redirect('{! table !}');
    }

    public function delete($id)
    {
        $this->{! singularTable !}->delete($id);
        return redirect('{! table !}');
    }
}