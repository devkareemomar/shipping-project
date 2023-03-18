@php
    $user_role = auth()->user()->role;
    $admin = 1;
    $branch = 3;
    $client = 4;
@endphp

@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    {{ __('cargo::view.statistics') }}
@endsection

@section('content')
    @php
        if (check_module('Localization')) {
            $current_lang = Modules\Localization\Entities\Language::where('code', LaravelLocalization::getCurrentLocale())->first();
        }

        $user_role = auth()->user()->role;
        $admin = 1;
        $staff = 0;
        $branch = 3;
        $client = 4;
        $driver = 5;

        if ($user_role == $admin || $user_role == $staff) {
            if (
                $user_role == $admin ||
                auth()
                    ->user()
                    ->can('manage-branches')
            ) {
                $all_branchs = Modules\Cargo\Entities\Branch::where('is_archived', 0)->count();
            }
            if (
                $user_role == $admin ||
                auth()
                    ->user()
                    ->can('manage-staffs')
            ) {
                $all_staff = Modules\Cargo\Entities\Staff::count();
            }
            if (
                $user_role == $admin ||
                auth()
                    ->user()
                    ->can('manage-customers')
            ) {
                $all_clients = Modules\Cargo\Entities\Client::where('is_archived', 0)->count();
            }
            if (
                $user_role == $admin ||
                auth()
                    ->user()
                    ->can('manage-drivers')
            ) {
                $all_captains = Modules\Cargo\Entities\Driver::where('is_archived', 0)->count();
            }
        } elseif ($user_role == $branch) {
            $branch_id = Modules\Cargo\Entities\Branch::where('user_id', auth()->user()->id)
                ->pluck('id')
                ->first();

            $all_clients = Modules\Cargo\Entities\Client::where('is_archived', 0)
                ->where('branch_id', $branch_id)
                ->count();
            $all_captains = Modules\Cargo\Entities\Driver::where('is_archived', 0)
                ->where('branch_id', $branch_id)
                ->count();
            $all_staff = Modules\Cargo\Entities\Staff::where('branch_id', $branch_id)->count();
        }

    @endphp


    @if (
        $user_role == $admin ||
            auth()->user()->can('manage-branches'))
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $all_branchs }}</h3>
                    <p>{{ __('cargo::view.all_branches') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <a href="{{ route('branches.index') }}" class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    @endif

    @if (in_array($user_role, [$admin, $branch]) ||
            auth()->user()->can('manage-staffs'))
        <div class=@if ($user_role == $admin) "col-xl-3 col-6" @else "col-xl-4 col-6" @endif>
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $all_staff }}</h3>
                    <p>{{ __('cargo::view.all_staffs') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('staffs.index') }}" class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    @endif

    @if (in_array($user_role, [$admin, $branch]) ||
            auth()->user()->can('manage-customers'))
        <div class=@if ($user_role == $admin) "col-xl-3 col-6" @else "col-xl-4 col-6" @endif>
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $all_clients }}</h3>
                    <p>{{ __('cargo::view.all_clients') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <a href="{{ route('clients.index') }}" class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    @endif

    @if (in_array($user_role, [$admin, $branch]) ||
            auth()->user()->can('manage-drivers'))
        <div class=@if ($user_role == $admin) "col-xl-3 col-6" @else "col-xl-4 col-6" @endif>
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $all_captains }}</h3>
                    <p>{{ __('cargo::view.all_drivers') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-people-carry"></i>
                </div>
                <a href="{{ route('drivers.index') }}" class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    @endif

    @if (
        $user_role == $admin ||
            auth()->user()->can('manage-missions') ||
            auth()->user()->can('manage-shipments'))
        @php
            $all_shipments = Modules\Cargo\Entities\Shipment::count();
            $pending_shipments = Modules\Cargo\Entities\Shipment::whereIn('status_id', [Modules\Cargo\Entities\Shipment::REQUESTED_STATUS, Modules\Cargo\Entities\Shipment::CAPTAIN_ASSIGNED_STATUS, Modules\Cargo\Entities\Shipment::RECIVED_STATUS, Modules\Cargo\Entities\Shipment::RETURNED_STOCK])->count();
            $delivered_shipments = Modules\Cargo\Entities\Shipment::whereIn('status_id', [Modules\Cargo\Entities\Shipment::DELIVERED_STATUS, Modules\Cargo\Entities\Shipment::SUPPLIED_STATUS, Modules\Cargo\Entities\Shipment::RETURNED_CLIENT_GIVEN])->count();

            $all_missions = Modules\Cargo\Entities\Mission::count();
            $pending_missions = Modules\Cargo\Entities\Mission::whereIn('status_id', [Modules\Cargo\Entities\Mission::REQUESTED_STATUS, Modules\Cargo\Entities\Mission::APPROVED_STATUS, Modules\Cargo\Entities\Mission::RECIVED_STATUS])->count();
            $pickup_missions = Modules\Cargo\Entities\Mission::where('type', Modules\Cargo\Entities\Mission::PICKUP_TYPE)->count();
            $delivery_missions = Modules\Cargo\Entities\Mission::where('type', Modules\Cargo\Entities\Mission::DELIVERY_TYPE)->count();
            $transfer_missions = Modules\Cargo\Entities\Mission::where('type', Modules\Cargo\Entities\Mission::TRANSFER_TYPE)->count();
            $supply_missions = Modules\Cargo\Entities\Mission::where('type', Modules\Cargo\Entities\Mission::SUPPLY_TYPE)->count();
        @endphp

        <!-- row -->
        <div class="row col-12">
            <div class="col-12">
                <!-- jQuery Knob -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-bar"></i>
                            {{ __('cargo::view.statistics') }}
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">

                            <!-- ./col -->
                            <div class="col-6 col-md-3 text-center">
                                <input type="text" class="knob" value="{{ $pending_shipments }}" data-width="90"
                                    data-height="90" data-fgColor="#f56954" data-readonly="true" disabled
                                    style="{{ isset($current_lang) && $current_lang->dir == 'rtl' ? 'margin-right: -69px;' : '' }}">

                                <div class="knob-label">{{ __('cargo::view.pending_shipments') }}</div>
                            </div>

                            <div class="col-6 col-md-3 text-center">
                                <input type="text" class="knob" disabled value="{{ $delivered_shipments }}"
                                    data-width="90" data-height="90" data-fgColor="#3c8dbc" data-height="90"
                                    data-fgColor="#f56954" data-readonly="true" disabled
                                    style="{{ isset($current_lang) && $current_lang->dir == 'rtl' ? 'margin-right: -69px;' : '' }}">

                                <div class="knob-label">{{ __('cargo::view.delivered_shipments') }}</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6 col-md-3 text-center">
                                <input type="text" class="knob" value="{{ $all_clients }}" data-width="90"
                                    data-height="90" data-fgColor="#00a65a" ddata-height="90" data-fgColor="#f56954"
                                    data-readonly="true" disabled
                                    style="{{ isset($current_lang) && $current_lang->dir == 'rtl' ? 'margin-right: -69px;' : '' }}">

                                <div class="knob-label">{{ __('cargo::view.all_clients') }}</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6 col-md-3 text-center">
                                <input type="text" class="knob" value="{{ $all_captains }}" data-width="90"
                                    data-height="90" data-fgColor="#00c0ef" data-height="90" data-fgColor="#f56954"
                                    data-readonly="true" disabled
                                    style="{{ isset($current_lang) && $current_lang->dir == 'rtl' ? 'margin-right: -69px;' : '' }}">

                                <div class="knob-label">{{ __('cargo::view.all_drivers') }}</div>
                            </div>

                            <!-- ./col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-6 text-center">
                                <input type="text" class="knob" value="{{ $all_shipments }}" data-width="90"
                                    data-height="90" data-fgColor="#932ab6" data-height="90" data-fgColor="#f56954"
                                    data-readonly="true" disabled
                                    style="{{ isset($current_lang) && $current_lang->dir == 'rtl' ? 'margin-right: -69px;' : '' }}">

                                <div class="knob-label">{{ __('cargo::view.all_Shipments') }}</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6 text-center">
                                <input type="text" class="knob" value="50" data-width="90" data-height="90"
                                    data-fgColor="#39CCCC" data-height="90" data-fgColor="#f56954" data-readonly="true"
                                    disabled
                                    style="{{ isset($current_lang) && $current_lang->dir == 'rtl' ? 'margin-right: -69px;' : '' }}">

                                <div class="knob-label">CPU</div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $all_shipments }}</h3>
                    <p>{{ __('cargo::view.all_Shipments') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('shipments.index') }}" class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $pending_shipments }}</h3>
                    <p>{{ __('cargo::view.pending_shipments') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('shipments.index', ['status' => [Modules\Cargo\Entities\Shipment::REQUESTED_STATUS, Modules\Cargo\Entities\Shipment::CAPTAIN_ASSIGNED_STATUS, Modules\Cargo\Entities\Shipment::RETURNED_STOCK, Modules\Cargo\Entities\Shipment::RECIVED_STATUS]]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $delivered_shipments }}</h3>
                    <p>{{ __('cargo::view.delivered_shipments') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('shipments.index', ['status' => [Modules\Cargo\Entities\Shipment::RETURNED_CLIENT_GIVEN, Modules\Cargo\Entities\Shipment::SUPPLIED_STATUS, Modules\Cargo\Entities\Shipment::DELIVERED_STATUS]]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $all_missions }}</h3>
                    <p>{{ __('cargo::view.all_missions') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <a href="{{ route('missions.index', ['status' => 'all']) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pending_missions }}</h3>
                    <p>{{ __('cargo::view.pending_missions') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <a href="{{ route('missions.index', ['status' => [Modules\Cargo\Entities\Mission::REQUESTED_STATUS, Modules\Cargo\Entities\Mission::APPROVED_STATUS, Modules\Cargo\Entities\Mission::RECIVED_STATUS]]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $pickup_missions }}</h3>
                    <p>{{ __('cargo::view.pickup_missions') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <a href="{{ route('missions.index', ['type' => [Modules\Cargo\Entities\Mission::PICKUP_TYPE]]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $delivery_missions }}</h3>
                    <p>{{ __('cargo::view.delivery_missions') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <a href="{{ route('missions.index', ['type' => [Modules\Cargo\Entities\Mission::DELIVERY_TYPE]]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $transfer_missions }}</h3>
                    <p>{{ __('cargo::view.transfer_missions') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <a href="{{ route('missions.index', ['type' => [Modules\Cargo\Entities\Mission::TRANSFER_TYPE]]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $supply_missions }}</h3>
                    <p>{{ __('cargo::view.supply_missions') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <a href="{{ route('missions.index', ['type' => [Modules\Cargo\Entities\Mission::SUPPLY_TYPE]]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    @elseif($user_role == $branch)
        @php
            $all_shipments = Modules\Cargo\Entities\Shipment::where('branch_id', $branch_id)->count();
            $pending_shipments = Modules\Cargo\Entities\Shipment::where('branch_id', $branch_id)
                ->whereIn('status_id', [Modules\Cargo\Entities\Shipment::REQUESTED_STATUS, Modules\Cargo\Entities\Shipment::CAPTAIN_ASSIGNED_STATUS, Modules\Cargo\Entities\Shipment::RECIVED_STATUS, Modules\Cargo\Entities\Shipment::RETURNED_STOCK])
                ->count();
            $delivered_shipments = Modules\Cargo\Entities\Shipment::where('branch_id', $branch_id)
                ->whereIn('status_id', [Modules\Cargo\Entities\Shipment::DELIVERED_STATUS, Modules\Cargo\Entities\Shipment::SUPPLIED_STATUS, Modules\Cargo\Entities\Shipment::RETURNED_CLIENT_GIVEN])
                ->count();
        @endphp

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $all_shipments }}</h3>
                    <p>{{ __('cargo::view.all_Shipments') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('shipments.index', ['branch_id' => $branch_id]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $pending_shipments }}</h3>
                    <p>{{ __('cargo::view.pending_shipments') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('shipments.index', ['status' => [Modules\Cargo\Entities\Shipment::REQUESTED_STATUS, Modules\Cargo\Entities\Shipment::CAPTAIN_ASSIGNED_STATUS, Modules\Cargo\Entities\Shipment::RETURNED_STOCK, Modules\Cargo\Entities\Shipment::RECIVED_STATUS], 'branch_id' => $branch_id]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $delivered_shipments }}</h3>
                    <p>{{ __('cargo::view.delivered_shipments') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('shipments.index', ['status' => [Modules\Cargo\Entities\Shipment::RETURNED_CLIENT_GIVEN, Modules\Cargo\Entities\Shipment::SUPPLIED_STATUS, Modules\Cargo\Entities\Shipment::DELIVERED_STATUS], 'branch_id' => $branch_id]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    @elseif($user_role == $client)
        @php
            $client_id = Modules\Cargo\Entities\Client::where('user_id', auth()->user()->id)
                ->pluck('id')
                ->first();
            $all_client_shipments = Modules\Cargo\Entities\Shipment::where('client_id', $client_id)->count();
            $saved_client_shipments = Modules\Cargo\Entities\Shipment::where('client_id', $client_id)
                ->where('status_id', Modules\Cargo\Entities\Shipment::SAVED_STATUS)
                ->count();
            $in_progress_client_shipments = Modules\Cargo\Entities\Shipment::where('client_id', $client_id)
                ->where('client_status', Modules\Cargo\Entities\Shipment::CLIENT_STATUS_IN_PROCESSING)
                ->count();
            $delivered_client_shipments = Modules\Cargo\Entities\Shipment::where('client_id', $client_id)
                ->where('client_status', Modules\Cargo\Entities\Shipment::CLIENT_STATUS_DELIVERED)
                ->count();

            $transactions = Modules\Cargo\Entities\Transaction::where('client_id', $client_id)
                ->orderBy('created_at', 'desc')
                ->sum('value');
            $DEBIT_transactions = Modules\Cargo\Entities\Transaction::where('client_id', $client_id)
                ->where('value', 'like', '%-%')
                ->orderBy('created_at', 'desc')
                ->sum('value');
            $CREDIT_transactions = Modules\Cargo\Entities\Transaction::where('client_id', $client_id)
                ->where('value', 'not like', '%-%')
                ->orderBy('created_at', 'desc')
                ->sum('value');

            // DEBIT  -
            // CREDIT  +

        @endphp

        <div class="col-lg-12">
            <!--begin::Stats Widget 30-->
            <div class="card card-custom bgi-no-repeat card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <a href="{{ route('transactions.index') }}"
                        class="mb-0 font-weight-bold text-light-75 text-hover-primary font-size-h5">{{ __('cargo::view.your_wallet') }}
                        <div class="font-weight-bold text-success mt-2">{{ format_price($CREDIT_transactions) }}</div>
                        <div class="font-weight-bold text-danger mt-3">{{ format_price($DEBIT_transactions) }}</div>
                        <div style="width: 15%;height: 1px;background-color: #3f4254;margin-top: 9px;"></div>
                        <div class="mb-3 font-weight-bold text-success mt-4">{{ format_price($transactions) }}</div>
                    </a>
                    <p class="m-0 text-dark-75 font-weight-bolder font-size-h5">
                        {{ __('cargo::view.client_wallet_dashboard') }}.</p>

                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 30-->
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $all_client_shipments }}</h3>
                    <p>{{ __('cargo::view.all_Shipments') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('shipments.index', ['client_id' => $client_id]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $saved_client_shipments }}</h3>
                    <p>{{ __('cargo::view.saved_shipments') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('shipments.index', ['status' => [Modules\Cargo\Entities\Shipment::SAVED_STATUS], 'client_id' => $client_id]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $in_progress_client_shipments }}</h3>
                    <p>{{ __('cargo::view.in_progress_shipments') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('shipments.index', ['client_status' => [Modules\Cargo\Entities\Shipment::CLIENT_STATUS_IN_PROCESSING], 'client_id' => $client_id]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $delivered_client_shipments }}</h3>
                    <p>{{ __('cargo::view.delivered_shipments') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('shipments.index', ['client_status' => [Modules\Cargo\Entities\Shipment::CLIENT_STATUS_DELIVERED], 'client_id' => $client_id]) }}"
                    class="small-box-footer">{{ __('cargo::view.more_info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    @elseif($user_role == $driver)
        @php
            $driver_id = Modules\Cargo\Entities\Driver::where('user_id', auth()->user()->id)
                ->pluck('id')
                ->first();
            $transactions = Modules\Cargo\Entities\Transaction::where('captain_id', $driver_id)
                ->orderBy('created_at', 'desc')
                ->sum('value');
            $transactions = abs($transactions); // Converting the transactions from negative to positive
        @endphp

        <div class="col-lg-12">
            <!--begin::Stats Widget 30-->
            <div class="card card-custom bgi-no-repeat card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <a href="{{ route('transactions.index') }}"
                        class="mb-0 font-weight-bold text-light-75 text-hover-primary font-size-h5">{{ __('cargo::view.your_wallet') }}
                        <div class="mt-0 mb-5 font-weight-bold font-size-h4 text-success mt-9">
                            {{ format_price($transactions) }}</div>
                    </a>
                    <p class="m-0 text-dark-75 font-weight-bolder font-size-h5">
                        {{ __('cargo::view.driver_wallet_dashboard') }}.</p>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 30-->
        </div>
    @endif
@endsection






{{-- Inject Scripts --}}
@section('scripts')
    <!-- Page specific script -->
    <script>
        $(function() {
            /* jQueryKnob */

            $('.knob').knob({
                /*change : function (value) {
                 //console.log("change : " + value);
                 },
                 release : function (value) {
                 console.log("release : " + value);
                 },
                 cancel : function () {
                 console.log("cancel : " + this.value);
                 },*/
                draw: function() {

                    // "tron" case
                    if (this.$.data('skin') == 'tron') {

                        var a = this.angle(this.cv) // Angle
                            ,
                            sa = this.startAngle // Previous start angle
                            ,
                            sat = this.startAngle // Start angle
                            ,
                            ea // Previous end angle
                            ,
                            eat = sat + a // End angle
                            ,
                            r = true

                        this.g.lineWidth = this.lineWidth

                        this.o.cursor &&
                            (sat = eat - 0.3) &&
                            (eat = eat + 0.3)

                        if (this.o.displayPrevious) {
                            ea = this.startAngle + this.angle(this.value)
                            this.o.cursor &&
                                (sa = ea - 0.3) &&
                                (ea = ea + 0.3)
                            this.g.beginPath()
                            this.g.strokeStyle = this.previousColor
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
                            this.g.stroke()
                        }

                        this.g.beginPath()
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
                        this.g.stroke()

                        this.g.lineWidth = 2
                        this.g.beginPath()
                        this.g.strokeStyle = this.o.fgColor
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth *
                            2 / 3, 0, 2 * Math.PI, false)
                        this.g.stroke()

                        return false
                    }
                }
            })
            /* END JQUERY KNOB */

            //INITIALIZE SPARKLINE CHARTS
            // var sparkline1 = new Sparkline($('#sparkline-1')[0], { width: 240, height: 70, lineColor: '#92c1dc', endColor: '#92c1dc' })
            // var sparkline2 = new Sparkline($('#sparkline-2')[0], { width: 240, height: 70, lineColor: '#f56954', endColor: '#f56954' })
            // var sparkline3 = new Sparkline($('#sparkline-3')[0], { width: 240, height: 70, lineColor: '#3af221', endColor: '#3af221' })

            // sparkline1.draw([1000, 1200, 920, 927, 931, 1027, 819, 930, 1021])
            // sparkline2.draw([515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921])
            // sparkline3.draw([15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21])

        })
    </script>
@endsection
