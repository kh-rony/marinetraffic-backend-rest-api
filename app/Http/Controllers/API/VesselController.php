<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Vessel;
use Illuminate\Http\Request;
use SoapBox\Formatter\Formatter;

class VesselController extends Controller
{
    // create vessel records
    public function createVessels(Request $request)
    {
        $rows = json_decode($request->getContent());

        foreach( $rows as $row )
        {
            $vessel = new Vessel();
            $vessel->mmsi = $row->mmsi;
            $vessel->status = $row->status;
            $vessel->stationId = $row->stationId;
            $vessel->speed = $row->speed;
            $vessel->lat = $row->lat;
            $vessel->lon = $row->lon;
            $vessel->course = $row->course;
            $vessel->heading = $row->heading;
            $vessel->rot = $row->rot;
            $vessel->timestamp = $row->timestamp;

            $vessel->save();
        }

        return response()->json(["message" => "vessel records created successfully"], 201);
    }

    public function prepareResponseForVessels(Request $request)
    {
        $query = Vessel::query();

        // filtering lat
        if( $request->has('minLat') )
        {
            $query->where('lat', '>=', $request->get('minLat'));
        }
        if( $request->has('maxLat') )
        {
            $query->where('lat', '<=', $request->get('maxLat'));
        }

        // filtering lon
        if( $request->has('minLon') )
        {
            $query->where('lon', '>=', $request->get('minLon'));
        }
        if( $request->has('maxLon') )
        {
            $query->where('lon', '<=', $request->get('maxLon'));
        }

        // filtering timestamp
        if( $request->has('minTimestamp') )
        {
            $query->where('timestamp', '>=', $request->get('minTimestamp'));
        }
        if( $request->has('maxTimestamp') )
        {
            $query->where('timestamp', '<=', $request->get('maxTimestamp'));
        }

        // filtering single or multiple mmsi
        if( $request->has('singleMmsi') && $request->get('singleMmsi') == 'true' )
        {
            $newQuery = clone $query;
            $newQuery->where('mmsi', '=', $query->first('mmsi')['mmsi']);

            $vessels = $newQuery->select(
                'mmsi',
                'status',
                'stationId',
                'speed',
                'lat',
                'lon',
                'course',
                'heading',
                'rot',
                'timestamp')->get();

            return $vessels;
        }

        $vessels = $query->select(
            'mmsi',
            'status',
            'stationId',
            'speed',
            'lat',
            'lon',
            'course',
            'heading',
            'rot',
            'timestamp')->get();

        return $vessels;
    }

    // get vessels JSON
    public function getVesselsJSON(Request $request)
    {
        $vessels = $this->prepareResponseForVessels($request);

        return response($vessels->toJson(JSON_PRETTY_PRINT), 200)
            ->header('Content-Type', 'application/json');
    }

    // get vessels XML
    public function getVesselsXML(Request $request)
    {
        $vessels = $this->prepareResponseForVessels($request);
        $formatter = Formatter::make($vessels, Formatter::XML);

        return response($formatter->toXml(), 200)
            ->header('Content-Type', 'application/xml');
    }

    // get vessels CSV
    public function getVesselsCSV(Request $request)
    {
        $vessels = $this->prepareResponseForVessels($request);
        $formatter = Formatter::make(strval($vessels), Formatter::CSV);

        return response($formatter->toCsv(), 200)
            ->header('Content-Type', 'text/csv');
    }

    // get single vessel JSON
    public function getSingleVesselJSON($id)
    {
        if( Vessel::where('id', $id)->exists() )
        {
            $vessel = Vessel::where('id', $id)->first()->toJson(JSON_PRETTY_PRINT);
            return response($vessel, 200)
                ->header('Content-Type', 'application/json');
        }
        return response()->json(["message" => "Vessel not found"], 404);
    }

    // get single vessel XML
    public function getSingleVesselXML($id)
    {
        if( Vessel::where('id', $id)->exists() )
        {
            $vessel = Vessel::where('id', $id)->first();
            $formatter = Formatter::make($vessel, Formatter::XML);

            return response($formatter->toXml(), 200)
                ->header('Content-Type', 'application/xml');
        }
        return response()->json(["message" => "Vessel not found"], 404);
    }

    // get single vessel CSV
    public function getSingleVesselCSV($id)
    {
        if( Vessel::where('id', $id)->exists() )
        {
            $vessel = Vessel::where('id', $id)->first();
            $formatter = Formatter::make(strval($vessel), Formatter::CSV);

            return response($formatter->toCsv(), 200)
                ->header('Content-Type', 'text/csv');
        }
        return response()->json(["message" => "Vessel not found"], 404);
    }
}
