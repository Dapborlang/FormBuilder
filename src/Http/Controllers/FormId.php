namespace Rdmarwein\Formbuilder\Http\Controllers;

use Rdmarwein\Formbuilder\FormMaster;


class FormId
{
    public function getFormId($header)
    {
        $formPopulate=FormMaster::select('id')
        ->where('header',$header)
        ->first();

        return $formPopulate;
    }
}