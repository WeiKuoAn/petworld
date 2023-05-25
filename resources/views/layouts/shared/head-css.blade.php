@yield('css')

<!-- icons -->
<link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />


@if(isset($mode) && $mode == 'rtl')

<!-- App css -->
@if(isset($demo) && $demo == 'creative')
<link href="{{asset('assets/css/creative/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/creative/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/creative/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/creative/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'modern')
<link href="{{asset('assets/css/modern/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/modern/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/modern/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/modern/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'material')
<link href="{{asset('assets/css/material/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/material/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/material/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/material/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'purple')
<link href="{{asset('assets/css/purple/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/purple/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/purple/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/purple/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'saas')
<link href="{{asset('assets/css/saas/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/saas/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/saas/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/saas/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
<link href="{{asset('assets/css/default/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/default/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/default/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/default/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@endif
@endif
@endif
@endif
@endif

@else
<!-- App css -->
@if(isset($demo) && $demo == 'creative')
<link href="{{asset('assets/css/creative/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/creative/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/creative/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/creative/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'modern')
<link href="{{asset('assets/css/modern/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/modern/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/modern/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/modern/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'material')
<link href="{{asset('assets/css/material/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/material/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/material/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/material/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'purple')
<link href="{{asset('assets/css/purple/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/purple/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/purple/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/purple/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'saas')
<link href="{{asset('assets/css/saas/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/saas/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/saas/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/saas/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
<link href="{{asset('assets/css/default/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/default/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/default/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/default/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@endif
@endif
@endif
@endif
@endif
@endif