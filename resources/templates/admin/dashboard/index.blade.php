@extends('layouts.admin.master')

@section('content')

<div class="row"><div class="col-md-12"><h3 class="page-title">Home</h3><ul class="page-breadcrumb breadcrumb"><li>Home</li></ul></div></div>
<div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                            116                            </div>
                            <div class="desc">
                                 LETTERS
                            </div>
                        </div>
                        <a class="more" href="/manage/admin/manage_letters.php">
                             View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="fa fa-hospital-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                4                            </div>
                            <div class="desc">
                                VOBs
                            </div>
                        </div>
                        <a class="more" href="/manage/admin/manage_vobs.php?status=0">
                             View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat purple">
                        <div class="visual">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                 4                            </div>
                            <div class="desc">
                                HSTs
                            </div>
                        </div>
                        <a class="more" href="/manage/admin/manage_hsts.php?status=1">
                             View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat yellow">
                        <div class="visual">
                            <i class="fa fa-medkit"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                10                            </div>
                            <div class="desc">
                                CLAIMS
                            </div>
                        </div>
                        <a class="more" href="/manage/admin/manage_claims.php?status=0">
                             View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat red">
                        <div class="visual">
                            <i class="fa  fa-question"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                21                            </div>
                            <div class="desc">
                                TICKETS
                            </div>
                        </div>
                        <a class="more" href="/manage/admin/manage_support_tickets.php">
                             View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                        </div>
@stop
@stop