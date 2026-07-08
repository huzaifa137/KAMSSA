@extends('layouts.master')
@section('css')
<!-- Morris Charts css -->
<link href="{{URL::asset('assets/plugins/morris/morris.css')}}" rel="stylesheet" />
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<!--Daterangepicker css-->
<link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<!-- treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">My Dashboard</h4>
							</div>
							
						</div>
						<!--End Page header-->
@endsection
@section('content')
						<!--Row-->
						<div class="row">
							
							<div class="col-xl-12 col-md-12 col-lg-12">

							<div style="border-bottom:1px solid #000;margin-bottom:20px;"></div>

							<h4 class="text-primary">Modules</h4>
							<div class="row">
							<div class="col-md-2 my-dashboard-modules">
								<a href=""><img style="width:80px;" src="{{URL::asset('assets/images/home/airticketing.png')}}" alt=""/>
								<br/>
								Air Ticketing</a>
							</div>

							<div class="col-md-2 my-dashboard-modules">
								<a href=""><img style="width:80px;" src="{{URL::asset('assets/images/home/suppliers.png')}}" alt=""/>
								<br/>
								Suppliers</a>
							</div>

							<div class="col-md-2 my-dashboard-modules">
								<a href=""><img style="width:80px;" src="{{URL::asset('assets/images/home/procurementplan.png')}}" alt=""/>
								<br/>
								Procurement Plan</a>
							</div>

							<div class="col-md-2 my-dashboard-modules">
								<a href=""><img style="width:80px;" src="{{URL::asset('assets/images/home/requisition.png')}}" alt=""/>
								<br/>
								Requisitioning</a>
							</div>

							<div class="col-md-2 my-dashboard-modules">
								<a href=""><img style="width:80px;" src="{{URL::asset('assets/images/home/assetdisposal.png')}}" alt=""/>
								<br/>
								Asset Disposal</a>
							</div>

							<div class="col-md-2 my-dashboard-modules">
								<a href=""><img style="width:80px;" src="{{URL::asset('assets/images/home/tender.png')}}" alt=""/>
								<br/>
								Tendering</a>
							</div>

							<div class="col-md-2 my-dashboard-modules">
								<a href=""><img style="width:80px;" src="{{URL::asset('assets/images/home/users.png')}}" alt=""/>
								<br/>
								Users Admin</a>
							</div>
							</div>

							<div style="border-bottom:1px solid #000;margin-bottom:20px;"></div>

							
						<div class="row">
							<div class="col-md-4">							
							<h4 class="text-primary">Delegation</h4>
							@foreach($active_delegation as $del)
							<div class="col-xl-12 col-lg-12">
								<div class="card border p-0 shadow-none">
									<div class="d-flex align-items-center p-4">
										<?php 
										echo \App\Http\Controllers\Controller::letterAvatar2(@$del->adminid, $del->firstname.' '.$del->lastname, 50);
										?>
										<div class="wrapper ml-3">
											<p class="mb-0 mt-1 text-dark font-weight-semibold">Delegator: <br/><small>{{$del->firstname}} {{$del->lastname}}</small></p>
										</div>
									</div>
									<div class="card-body pt-2">
										<div class="d-flex mb-3">
											<i class="fa fa-fw fa-calendar"></i>
											<div class="h6 mb-0 ml-3 mt-0">{{\App\Http\Controllers\Helper::date_fm($del->del_start_date)}}<br/>{{\App\Http\Controllers\Helper::date_fm($del->del_end_date)}}</div>
										</div>
										<div class="d-flex mb-3">
										<i class="fa fa-fw fa-calendar"></i>
											<div class="h6 mb-0 ml-3 mt-0">Days : {{ @$others['days'][$del->id] }} </div>
										</div>
										<div class="d-flex mb-3">
											<i class="fa fa-fw fa-question"></i>			
											<div class="h6 mb-0 ml-3 mt-0">Status: {!! @$others['status'][$del->id] !!} </div>
										</div>
										
									</div>
								</div>
							</div>
							@endforeach									
							</div>

							<div class="col-md-4">
								<h4 class="text-primary">User Roles ({{count($user_role_list)}})</h4>
								<div style="max-height:200px;overflow:auto;">
									<ul>
										{!! $user_role !!}
									</ul>
								</div>
							</div>

							<div class="col-md-4">
								<h4 class="text-primary">User Divisions ({{count($division_list)}})</h4>
								<div style="max-height:200px;overflow:auto;">
									<ul>
										{!! $user_division !!}
									</ul>
								</div>
							</div>

						</div>
						
						<div style="border-bottom:1px solid #000;margin-bottom:20px;"></div>
						<div style="" class="row mb-5 pb-5">
							<div class="col-md-6">
								<h4 class="text-primary">My Team under User Role ({{count($user_role_list)}})</h4>
								<ul id="tree1">
									@foreach($user_role_list as $user)							
									<li><a href="#">{{$user->user_name}} ({{@count($role_team[$user->uar_role_id])}})</a>
										<ul>
											@foreach($role_team[$user->uar_role_id] as $name)
											<li>{{$name}} </li>
											@endforeach
										</ul>
									</li>
									@endforeach
								</ul>
							</div>
							<div class="col-md-6">
								<h4 class="text-primary">My Team under Divisions ({{count($division_list)}})</h4>
								<ul id="treeview1">											
									@foreach($division_list as $division)							
									<li><a href="#">{{$division->md_code}} ({{ @count($division_team[$division->ud_division]) }})</a>
										<ul>
											@foreach($division_team[$division->ud_division] as $name)
											<li>{{$name}}</li>
											@endforeach
										</ul>
									</li>
									@endforeach
								</ul>
							</div>
						</div>

						</div>

						</div>
						</div>
					</div>
				</div><!-- end app-content-->
			</div>
@endsection
@section('js')
<!-- Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
<!--Moment js-->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>
<!-- Daterangepicker js-->
<script src="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/daterange.js')}}"></script>
<!--Chart js -->
<script src="{{URL::asset('assets/plugins/chart/chart.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/chart/chart.extension.js')}}"></script>
<!-- ECharts js-->
<script src="{{URL::asset('assets/plugins/echarts/echarts.js')}}"></script>
<script src="{{URL::asset('assets/js/index2.js')}}"></script>
@endsection