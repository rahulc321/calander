<?php
namespace App\Http\Controllers\Admin;

use App\Helpers\Authority;
use App\Http\Controllers\Controller;
use App\Modules\Circuits\Circuit;
use App\Modules\Circuits\CircuitRepository;
use App\Modules\Series\Series;
use App\Modules\Teams\Team;
use Exception;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use View;

class FetcherController extends Controller
{
    private $circuits;


    public function __construct(CircuitRepository $circuitRepository)
    {
        $this->circuits = $circuitRepository;

    }

    public function getCircuitFromSeries($id)
    {
        $series = Series::find($id);
        if (!$series) {
            throw new ApplicationException("Invalid Access");
        }
        return firstOption("Select Circuits") . OptionsView($series->circuits, 'id', 'name');
    }


    public function getMapFromCircuit($id)
    {
        $circuit = Circuit::find($id);
        if (!$circuit) {
            throw new ApplicationException("Invalid Access");
        }
        return '<img src="' . $circuit->getMap() . '">';
    }

    public function getRoundFromSeries($id)
    {
        $series = Series::find($id);
        if (!$series) {
            throw new ApplicationException("Invalid Access");
        }
        $rounds = [];
        for ($i = 1; $i <= $series->round; $i++) {
            $rounds[] = '<option value="' . $i . '">' . $i . '</option>';
        }
        return $rounds;
    }

    public function getDriversFromTeam($id)
    {
        $team = Team::find($id);
        if (!$team) {
            throw new ApplicationException("Invalid Access");
        }
        return firstOption("Select Drivers") . OptionsView($team->drivers, 'id', 'name');
    }
}