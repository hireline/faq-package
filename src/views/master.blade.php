<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FAQ')</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    @section('head-resources')
    @show
    <style>
      .blue-eti{
        background-color: #00d1f3 !important;
      }
      /**Footer style*/
      footer {
        margin-top: 98px;
      }
      footer .row{
        margin-bottom: 0;
      }
      footer div#footer-content{
        padding-bottom: 20px;
        padding-top: 50px;
        background-color: #444444;
      }
      footer div#footer-bottom{
        background-color: #2d2d2d;
      }
      footer p{
        font-size: 16px;
        font-weight: 600;
        font-style: normal;
        font-stretch: normal;
        line-height: normal;
        letter-spacing: normal;
        color: #dbdbdb;
        margin-bottom: 33px;
      }
      footer a{
        color: #dbdbdb;
        transition: all .5s linear;
      }
      footer a:hover{
        color: #00d1f3;
      }
      footer p small{
        display: block;
        margin-bottom: 6px;
      }
      footer .footer-section-title{
        font-size: 24px;
        font-weight: 600;
        font-style: normal;
        font-stretch: normal;
        line-height: normal;
        letter-spacing: normal;
        color: #ffffff;
      }
      footer div#footer-bottom .col.m12{
        display: flex;
        min-height: 70px;
        align-items: center;
        font-size: 1.5rem;
      }
      footer .social-networks a{
        font-size: 2.5rem;
        margin-right: 24px;
        color: white;
      }
      footer .social-networks-flex{
        display: flex;
      }
      /**End footer style*/
      nav img.logo {
        max-height: 40px;
        top: 10px;
        position: relative;
      }
      .tabs .tab a:focus, .tabs .tab a:focus.active {
        background-color: rgba(68, 68, 68, 0.20);
        outline: none;
      }
       td {
         padding: 15px;
       }

      tr {
        -webkit-transition: background-color .25s ease;
        transition: background-color .25s ease;
      }

      .post-title {
        color: #00abc6;
        font-size: 1.3rem;
        margin-block-start: 0em;
      }
    </style>
    @section('head-styles')            
    @show
  </head>
  <body>
    <div id="app">
      @yield('content')
    </div>
    @section('bottom-styles')
      <style>
        .search{ 
          position: relative; 
        }
        .search input{
          transition: background-color 0.25s ease;
          -webkit-transition: background-color 0.25s ease; 
          text-indent: 39px;
          height: 4rem;
          background-color: #ebeef1 !important;
        }
        #search { 
          position: absolute;
          top: 20px;
          left: 10px;
          font-size: 1.5rem;
        }
        input[type=text]:not(.browser-default){
          border-bottom: none;
        }
        input[type=text]:not(.browser-default):focus:not([readonly]){
          transition: background-color 0.25s ease;
          -webkit-transition: background-color 0.25s ease;
          -webkit-box-shadow: none;
          box-shadow: none;
          border-bottom: none;
          background-color: white !important;
        }
        input[type=search]:not(.browser-default){
          border-bottom: none;
        }
        input[type=search]:not(.browser-default):focus:not([readonly]){
          transition: background-color 0.25s ease;
          -webkit-transition: background-color 0.25s ease;
          -webkit-box-shadow: none;
          box-shadow: none;
          border-bottom: none;
          background-color: white !important;
        }
      </style>
    @show
    <!--  Font Awesome 5-->
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    @section('body-scripts')
      <script>
        $(document).ready(function(){
          $('.modal').modal();
        });
      </script>
    @show
  </body>
</html>