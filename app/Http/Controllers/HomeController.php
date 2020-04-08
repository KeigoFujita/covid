<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        return view('welcome');
    }


    public function fetchData()
    {
        $countries_json = [];
        $global_json = [];
        $global_timeline_json = [];
        $country_timeline = [];

        try {

            $countries_json = Http::withHeaders([
                'x-rapidapi-key' => 'e82ca27984msh8b025242f55a82ep11ea41jsn3a36aa4e1d22',
            ])->get('https://coronavirus-monitor.p.rapidapi.com/coronavirus/cases_by_country.php')->json();

            $global_json = Http::withHeaders([
                'x-rapidapi-key' => 'e82ca27984msh8b025242f55a82ep11ea41jsn3a36aa4e1d22',
            ])->get('https://coronavirus-monitor.p.rapidapi.com/coronavirus/worldstat.php')->json();

            $global_timeline_json = Http::get('https://api.coronastatistics.live/timeline/global')->json();
            $country_timeline = Http::get('https://pomber.github.io/covid19/timeseries.json')->json();
        } catch (Exception $e) {
              return response()->json([], 404);
        }

        $countries_data = Storage::disk('local')->get('countries.json');
        $countries_data_collection = collect(json_decode($countries_data, true));


        // dd($json);
        $raw_countries = $countries_json['countries_stat'];
        $collection_countries = collect($raw_countries);


        $data = $countries_data_collection->mapWithKeys(function ($item) {


            return [

                $item['name'] => [

                    "code" => $item['alpha2Code'],
                    "flag" => $item['flag'],
                    "population" => $item['population'],
                    "capital" => $item['capital']
                ]


            ];
        });



        $countries = collect([]);

        foreach ($collection_countries as $country) {
            $country_name = $country['country_name'];
            $country_code = "N/A";
            $country_flag = "";
            $country_population = 0;
            $country_capital = "";

            try {
                $country_code = $data[$country_name]['code'];
                $country_flag = $data[$country_name]['flag'];
                $country_population = $data[$country_name]['population'];
                $country_capital = $data[$country_name]['capital'];
            } catch (Exception $e) {
                //return response()->json([], 404);
            }

            if ($country_code == "US") {
                $country['country_name'] = "United States of America";
            }

            $country['country_code'] = $country_code;
            $country['flag'] = $country_flag;
            $country['population'] = $country_population;
            $country['capital'] = $country_capital;
            $countries->push($country);
        }



        $global_timeline_collection = collect($global_timeline_json)->map(function ($item, $key) {
            $item['year'] = $key;
            return $item;
        });

        $global_timeline_to_send = $global_timeline_collection->values();
        $to_send = ["countries" => $countries, "world" => $global_json, "world_timeline" => $global_timeline_to_send, "country_timeline" => $country_timeline];
        return response()->json($to_send, 200);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getDashboardData()
    {

        $global_json = [];
        try {

            $global_json = Http::withHeaders([
                'x-rapidapi-key' => 'e82ca27984msh8b025242f55a82ep11ea41jsn3a36aa4e1d22',
            ])->get('https://coronavirus-monitor.p.rapidapi.com/coronavirus/worldstat.php')->json();
        } catch (Exception $e) {
        }


        $data = collect($global_json);
        $data->pop();
        //  dd($data);

        return response()->json($data, 200);
    }


    public function getWorldTimeline()
    {

        $global_json = [];
        try {

            $global_json = Http::get('https://api.coronastatistics.live/timeline/global')->json();
        } catch (Exception $e) {
        }


        $data = collect($global_json)->map(function ($item, $key) {
            $item['year'] = $key;
            return $item;
        });

        $final_data = $data->values();
        return response()->json($final_data, 200);
    }

    public function getCountryMetadata(Request $request)
    {

        $country_code = $request->code;
        $countries_data = Storage::disk('local')->get('countries.json');



        $countries_data_collection = collect(json_decode($countries_data, true));
        $country_to_get = [];
        foreach ($countries_data_collection as $country) {
            if ($country_code === $country['alpha2Code']) {
                $country_to_get = $country;
                break;
            }
        }

        return response()->json($country_to_get, 200);
    }


    public function getTimeLine()
    {

        $country_timeline = Http::get('https://pomber.github.io/covid19/timeseries.json')->json();
        $country_to_get = [];
        $country_to_get['timeline'] = $country_timeline;
        return response()->json($country_to_get, 200);
    }
}