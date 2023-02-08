@php
namespace {namespace}\Controllers;

use CodeIgniter\Controller;
use {namespace}\Models\{! nameModel !};

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
        $user = auth()->user();
        if (! $user->inGroup('{! routegroup !}')) {
            echo 'Access denied';
            exit;
        }
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
        return view('{! address_views !}/index', [
            '{! table !}' => ${! table !}
        ]);
    }

    public function add()
    {
        $data = array();
{! modeldatajoin !}
        
        return view('{! address_views !}/add', $data);
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
            return view('{! address_views !}/add', $data);
        } else {
            return redirect('{! table !}');
        }
    }

    public function edit($id)
    {
{! modeldatajoin !}

        ${! singularTable !} = $this->{! singularTable !}->find($id);
        $data['value'] = ${! singularTable !};
        return view('{! address_views !}/edit', $data);
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