@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Main Content -->
<div class="container-fluid">
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">{{ __('stakeholders.stakeholders') }}</h6>
                    </div>
                    {{-- <div class="pull-right">
                        <a class="pull-left inline-block" href="{{ route('dashboard') }}" data-effect="fadeOut">
                            <i class="zmdi zmdi-close"></i>
                        </a>
                    </div> --}}
                    <div class="pull-right">
                        <a class="pull-left inline-block stakeholders-add" href="JavaScript:Void(0);" data-effect="fadeOut">
                            <i class="zmdi zmdi-account-add zmdi-hc-3x"></i>
                        </a>
                        {{-- <button type="submit" class="btn btn-primary">Add</button> --}}
                    </div>

                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div id="stakeholdersList" data-url="{{ route('stakeholders-list') }}"></div>
                        </div>
                        <!--Stakeholders modal-->
                        <div class="modal fade" id="stakeholders-modal" tabindex="-1" role="dialog" aria-labelledby="stakeholders-title">

                            <div class="modal-dialog" role="document">
                                <form class="modal-content form-horizontal" id="stakeholders-form" data-url="{{ route('stakeholders-add') }}">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">×</span></button>
                                        <h5 class="modal-title" id="stakeholders-title">Add stakeholders</h5>
                                    </div>
                                    <div class="modal-body">
                                        <input type="number" id="id" name="id" class="hidden" />
                                        <div class="form-group required">
                                            <label for="name" class="col-sm-3 control-label">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="email" class="col-sm-3 control-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email address"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="designation" class="col-sm-3 control-label">Designation</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="designation" name="designation"
                                                    placeholder="Job designation" required>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="phone" class="col-sm-3 control-label">phone</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="mobile" class="col-sm-3 control-label">Mobile</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile number"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
                                        <button type="button" id="stakeholdersAddButton" class="btn btn-primary" data-url="{{ route('stakeholders-add') }}">Save</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--/Editor-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
</div>
@endsection
