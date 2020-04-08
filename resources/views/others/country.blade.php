<div class="row" id="main-row">
    <div class="col-6 " style=" padding:0px !important" id="country_list">
        <div class="card shadow mx-3  mb-5 mt-3">
            <div class="card-header">
                <p class="font-weight-bold mb-0 "> Summary per Country</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table">
                        <thead>
                            <th>Country</th>
                            <th>Confirmed</th>
                            <th class="hide-me">Active</th>
                            <th class="hide-me">Deaths</th>
                            <th class="hide-me">Recovered</th>
                            <th class="no-sort">Actions</th>
                        </thead>
                        <tbody></tbody>
                        {{-- @foreach ($countries as $country)
                        <tr country="{{ $country['country_name'] }}" countryCode="{{  $country['country_code'] }}"
                        cases="{{$country['cases']}}" deaths="{{$country['deaths']}}"
                        recovered="{{$country['total_recovered']}}">
                        <td>

                            {{$country['country_name']}}
                        </td>
                        <td> {{$country['cases']}}</td>
                        <td> {{$country['active_cases']}}</td>
                        <td> {{$country['deaths']}}</td>
                        <td> {{$country['total_recovered']}}</td>
                        <td>
                            <button class="btn btn-success btn-sm btnView">View</button>

                        </td>
                        </tr>
                        @endforeach
                        --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6" style="padding:0px !important">
        <div class="country">
            <div class="row">
                <button class="btn btn-primary btn-small" id="back">Back</button>
            </div>
            <div class="row mt-5 px-3">
                <div class="col-md-3">
                    <img src="https://restcountries.eu/data/phl.svg" alt="" class="img-fluid shadow" id="flag_img">
                </div>
                <div class="col-md-9">
                    <p class="display-4" id="country_name">Phillipines</p>
                    <p class="capital" id="capital">Manila</p>
                </div>
            </div>

            <div class="row country-dashboard">
                <div class="col-md-6 add-margin">
                    <div class="card left-border-warning shadow country-card">
                        <p class="title text-warning">CASES</p>
                        <p class="value" id="country_cases">3,667</p>
                    </div>

                </div>
                <div class="col-md-6 add-margin">
                    <div class="card left-border-danger shadow country-card">
                        <p class="title text-danger">DEATHS</p>
                        <p class="value" id="country_deaths">3,667</p>
                    </div>
                </div>
            </div>

            <div class="row country-dashboard">
                <div class="col-md-6 add-margin">
                    <div class="card left-border-success shadow country-card">
                        <p class="title text-success">Recoveries</p>
                        <p class="value" id="country_recovered">3,667</p>
                    </div>

                </div>
                <div class="col-md-6 add-margin">
                    <div class="card left-border-info shadow country-card">
                        <p class="title text-info">Population</p>
                        <p class="value" id="population">1,000,000,000</p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 apply-padding ">
                <h1>Rate Distribution</h1>
                <div class="container-fluid card graphs shadow" id="country-pie-chart"></div>
            </div>

            <div class="row mt-5 apply-padding ">
                <h1>Cases History</h1>
                <div class="container-fluid card graphs shadow" id="country-cases-chart"></div>
            </div>

            <div class="row mt-5 apply-padding ">
                <h1>Deaths History</h1>
                <div class="container-fluid card graphs shadow" id="country-deaths-chart"></div>
            </div>

            <div class="row mt-5 apply-padding ">
                <h1>Recoveries History</h1>
                <div class="container-fluid card graphs shadow" id="country-recoveries-chart"></div>
            </div>

        </div>
    </div>
</div>