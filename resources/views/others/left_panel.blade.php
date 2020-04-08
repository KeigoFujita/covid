<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active " id="nav-world-tab" data-toggle="tab" href="#nav-world" role="tab"
            aria-controls="nav-world" aria-selected="false">World</a>
        <a class="nav-item nav-link " id="nav-country-tab" data-toggle="tab" href="#nav-country" role="tab"
            aria-controls="nav-country" aria-selected="true">Country</a>
    </div>
</nav>
<div class="tab-content left-panel border border-top-0 " id="nav-tabContent">

    <div class="tab-pane fade active show" id="nav-world" role="tabpanel" aria-labelledby="nav-home-tab">

        <div class="loader">
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <p class="text-dark">Fetching data</p>

        </div>

        <div class="world_main">
            <div id="world_dashboard" class="mb-5 mt-5 px-2" style="">
                <div class="row">
                    <div class="col-xl-4 main-dashboard-card-col">
                        <div class="card left-border-warning shadow main-dashboard-card">
                            <p class="text-warning">CASES
                            </p>
                            <p class="total" id="world_total_cases">

                            </p>
                        </div>
                    </div>
                    <div class="col-xl-4 main-dashboard-card-col">
                        <div class="card left-border-danger shadow main-dashboard-card">
                            <p class="text-danger">DEATHS
                            </p>
                            <p class="total" id="world_total_deaths">

                            </p>
                        </div>
                    </div>
                    <div class="col-xl-4 main-dashboard-card-col ">
                        <div class="card left-border-success shadow main-dashboard-card">
                            <p class="text-success">RECOVERIES
                            </p>
                            <p class="total" id="world_total_recoveries">

                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div id="world-chart" class="mb-5">
                <h1>Rate Distribution</h1>
                <div id="piechart" style="width:100%; height:300px;"></div>
            </div>

            <div id="world-chart" class="mb-5">
                <h1>Cases History</h1>
                <div id="cases_chart" style="width:100%; height:500px;"></div>
            </div>

            <div id="world-chart" class="mb-5">
                <h1>Deaths History</h1>
                <div id="deaths_chart" style="width:100%; height:500px;"></div>
            </div>

            <div id="world-chart" class="mb-5">
                <h1>Recoveries History</h1>
                <div id="recovered_chart" style="width:100%; height:500px;"></div>
            </div>
        </div>


    </div>

    <div class="tab-pane fade" id="nav-country" role="tabpanel" aria-labelledby="nav-country-tab">
        @include('others.country')
    </div>

</div>