<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="world_dashboard_url" content="{{ route('app.getDashboardData') }}">
    <meta name="world_timeline_url" content="{{ route('app.getWorldtimeline') }}">
    <meta name="country_get_metadata_url" content="{{ route('app.getCountryMetadata') }}">
    <meta name="country_get_timeline_url" content="{{ route('app.getTimeLine') }}">
    <meta name="country_fetch_data_url" content="{{ route('app.fetchData') }}">

    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: "Nunito";
        }

        body {
            overflow: hidden;
        }

        .main-view {
            height: 100vh;
        }

        .left-panel {
            overflow-x: hidden;
        }

        #nav-world {
            overflow-y: auto;
            overflow-x: hidden;
            height: 75vh;
        }

        #worldchartdiv,
        #countrychartdiv {
            height: 75vh;
            padding: 0px;
            margin-top: 40px;
            /* position: absolute;
            top: 100px; */

        }

        .main-dashboard-card {
            height: 100%;
            padding: 20px 20px;
            display: flex;
            justify-content: center;

        }

        .main-dashboard-card p {
            height: 100%;
            font-size: 0.8rem;
            line-height: 0.8rem;
            height: 0.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .main-dashboard-card .total {

            font-size: 1.5rem;
            font-weight: bold;
            color: #5a5c69;
            margin-bottom: 0px;
        }

        .left-border-warning {
            border-left: 5px solid #ffc107;
        }

        .left-border-danger {
            border-left: 5px solid #dc3545;
        }

        .left-border-success {
            border-left: 5px solid #28a745;
        }

        .left-border-info {
            border-left: 5px solid #17a2b8;
        }

        .header h1,
        span {
            padding-top: 50px;
            padding-left: 20px;
            font-family: "Segoe UI" !important;
        }

        .header h1 {
            font-weight: 400;
        }

        .header .main {
            font-weight: 500;
        }


        .dataTables_scrollBody::-webkit-scrollbar {
            width: 8px;
            box-shadow: none;
        }


        .dataTables_scrollBody::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .dataTables_scrollBody::-webkit-scrollbar-thumb {
            background-color: #444;
            border-radius: 4px;
        }

        div.table-responsive>div.dataTables_wrapper>div.row:nth-of-type(3) {
            margin-top: 20px;
        }



        #table tr td {
            vertical-align: middle;
        }

        #toggleView {
            position: absolute;
            top: 55px;
            left: 30px;
            z-index: 9999;
        }

        #nav-world::-webkit-scrollbar {
            width: 8px;
            box-shadow: none;
        }


        #nav-world::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        #nav-world::-webkit-scrollbar-thumb {
            background-color: #444;
            border-radius: 4px;
        }

        #world-chart h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            margin-left: 30px;
        }

        .country {
            padding-bottom: 50px;
        }

        .country .display-4 {
            font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol" !important;
            padding: 0px;
            line-height: 3.4rem;
            margin-bottom: 10px;

        }

        .country .capital {
            font-size: 1.3rem;
            margin-left: 3px;
            margin-top: 0px;
        }

        .country-dashboard {
            margin-top: 30px;
            padding: 0 15px;
        }

        .country-card {
            position: relative;
            height: 100px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: left;
            padding: 15px;
        }

        .country-card p {
            margin-bottom: 10px;
        }

        .country-card .title {
            position: absolute;
            top: 10px;
            left: 15px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .country-card .value {
            font-size: 2.5rem;
            line-height: 2.5rem;
            height: 2.5rem;
            font-weight: bold;

            margin-bottom: 0px;
            margin-top: 10px;
        }

        .graphs {
            height: 400px;
        }

        .apply-padding {
            padding: 0px 30px;
        }

        .country_main {
            position: relative;
        }

        #main-row {
            position: relative;
            width: calc(203% + 7px);
            padding: 0 15px;
        }

        #back {
            margin-left: 30px;
            ;
            margin-top: 1rem;
        }

        #country_list {
            position: relative;
            width: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            height: 75vh;
        }

        #country_list::-webkit-scrollbar {
            width: 8px;
            box-shadow: none;
        }


        #country_list::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        #country_list::-webkit-scrollbar-thumb {
            background-color: #444;
            border-radius: 4px;
        }

        .country {
            overflow-y: auto;
            overflow-x: hidden;
            height: 75vh;
            width: 100%;
        }

        .country::-webkit-scrollbar {
            width: 8px;
            box-shadow: none;
        }


        .country::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .country::-webkit-scrollbar-thumb {
            background-color: #444;
            border-radius: 4px;
        }

        .loader {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            flex-direction: column;
        }


        .loader p {
            margin-top: 10px;
            font-size: 1.3rem;
            display: block;
            color: #444;
        }

        .world_main {
            display: none;
            opacity: 0;

        }



        .error {
            text-align: center;
            font-size: 3rem;
            font-weight: bold;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 3px solid #dc3545 !important;
            -webkit-animation: shake 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both infinite;
            animation: shake 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both infinite;
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-perspective: 1000px;
            perspective: 1000px;
        }

        @-webkit-keyframes shake {

            10%,
            90% {
                -webkit-transform: translate3d(-1px, 0, 0);
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                -webkit-transform: translate3d(2px, 0, 0);
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                -webkit-transform: translate3d(-4px, 0, 0);
                transform: translate3d(-4px, 0, 0);
            }

            40%,
            60% {
                -webkit-transform: translate3d(4px, 0, 0);
                transform: translate3d(4px, 0, 0);
            }
        }

        @keyframes shake {

            10%,
            90% {
                -webkit-transform: translate3d(-1px, 0, 0);
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                -webkit-transform: translate3d(2px, 0, 0);
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                -webkit-transform: translate3d(-4px, 0, 0);
                transform: translate3d(-4px, 0, 0);
            }

            40%,
            60% {
                -webkit-transform: translate3d(4px, 0, 0);
                transform: translate3d(4px, 0, 0);
            }
        }


        .lds-ellipsis {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-ellipsis div {
            position: absolute;
            top: 33px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: #28a745;
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }

        .lds-ellipsis div:nth-child(1) {
            left: 8px;
            animation: lds-ellipsis1 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(2) {
            left: 8px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(3) {
            left: 32px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(4) {
            left: 56px;
            animation: lds-ellipsis3 0.6s infinite;
        }

        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(0);
            }
        }

        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(24px, 0);
            }
        }

        @media only screen and (max-width: 1199px) {

            .main-dashboard-card-col {

                margin-bottom: 30px;
                height: 100px;
            }

            body {
                overflow-y: auto;
            }


            body::-webkit-scrollbar {
                width: 8px;
                box-shadow: none;
            }


            body::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            /* Handle */
            body::-webkit-scrollbar-thumb {
                background-color: #444;
                border-radius: 4px;
            }

            .main-row {
                flex-direction: column-reverse;
            }

            .right-col {
                margin-bottom: 50px;
            }

            #nav-world {

                overflow-x: hidden;
                height: auto;
            }

            #worldchartdiv,
            #countrychartdiv {
                height: 50vh;
                margin-top: 0px;
            }

            #country_list {
                height: auto;
            }

            .loader {
                height: 50vh;
            }

            .country {
                height: max-content;
            }

            .country .display-4 {

                margin-top: 20px;
                line-height: 3.4rem;
            }

            .add-margin {
                margin-bottom: 1rem;
            }
        }

        @media only screen and (max-width: 600px) {
            .hide-me {
                display: none;
            }

            #table {
                width: 100% !important;
            }

            #back {
                margin-left: 30px;
                ;
                margin-top: 1rem;
            }
        }
    </style>
</head>

<body>
    @include('others.navbar')
    <main>

        <div class="container-fluid main-view" style="height:100vh">
            <div class="row main-row">
                <div class="col-lg-6 left-col">
                    @include('others.left_panel')

                </div>
                <div class="col-lg-6 right-col " class="country_main">
                    @include('others.right_panel')
                </div>
            </div>
        </div>

    </main>

</body>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="/js/dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.min.js"></script>
<script src="/js/app.js"></script>
<script src="/js/main.js"></script>

</html>