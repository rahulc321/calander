@extends('webpanel.layouts.base')
@section('title')
    Edit User
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Users Management</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @include('webpanel.includes.notifications')
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">Edit User</h6>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal ajaxForm" method="post"
                          action="<?php echo route('webpanel.users.update', array('id' => encryptIt($user->id))); ?>"
                          role="form" data-result-container="#notificationArea">

                        <input type="hidden" name="_method" value="put">

                        <div class="form-group">
                            <label class="col-sm-2">Full Name:</label>
                            <div class="col-sm-5">
                                <input type="text" placeholder="Full Name" class="form-control"
                                       name="full_name" value="{{ $user->full_name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Email Address:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Phone:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2">User Status:</label>
                            <div class="col-md-8">
                                <label class="radio-inline radio-success">
                                    <input type="radio" name="status" value="1"
                                           <?php echo isChecked(1, $user->status); ?> class="styled">
                                    Active
                                </label>

                                <label class="radio-inline radio-success">
                                    <input type="radio" name="status" value="0"
                                           <?php echo isChecked(0, $user->status); ?> class="styled">
                                    In-Active
                                </label>
                            </div>
                        </div>
                        <!-- 23 Aug -->
                        <div class="form-group">
                            <label class="col-md-2">Show On Map:</label>
                            <div class="col-md-8">
                                <label class="radio-inline radio-success">
                                    <input type="radio" name="map_status" value="0"
                                           <?php echo isChecked(0, $user->map_status); ?> class="styled">
                                    Hide
                                </label>

                                <label class="radio-inline radio-success">
                                    <input type="radio" name="map_status" value="1"
                                           <?php echo isChecked(1, $user->map_status); ?> class="styled">
                                    Show
                                </label>
                            </div>
                        </div>
                        <!-- 23 Aug -->


                        <div class="form-group">
                            <label class="col-sm-2">Address:</label>
                            <div class="col-sm-3">
                                <textarea name="address" class="form-control" style="min-height: 80px;">{{ $user->address }}</textarea>
                            </div>
                            <label class="col-sm-1">City:</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="city" value="{{ $user->city }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Country:</label>
                            <div class="col-sm-3">
                                <select class="form-control lazySelector" name="country"
                                        data-selected="{{ $user->country }}">
                                    <option value="">Select Country</option>
                                    {!! OptionsView(\App\Modules\Country::all(), 'name', 'name') !!}
                                </select>
                            </div>
                            <label class="col-sm-1">Zip Code:</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="zipcode" value="{{ $user->zipcode }}">
                            </div>
                        </div>


                        @if(auth()->user()->isAdmin() && $user->isCustomer())
                            <div class="form-group">
                                <label class="col-md-2" for="created_by">Assign To (Sales Person):</label>
                                <div class="col-md-3">
                                    <select class="form-control lazySelector" id="created_by" name="created_by"
                                            data-selected="{{ $user->created_by }}">
                                        <option value="{{ auth()->user()->id }}">Administrator</option>
                                        {!! OptionsView(\App\User::sales()->get(), 'id', function($item){
                                        return $item->fullName();
                                        }) !!}
                                    </select>
                                </div>
                            </div>

                            <div class="hideable" id="type-{{ \App\Modules\Users\Types\UserType::CUSTOMER }}">
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="debitor_number">Debitor Number:</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" id="debitor_number"
                                               name="debitor_number"
                                               value="{{ $user->debitor_number > 0 ? $user->debitor_number : \App\User::getNewDebitorValue() }}">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label class=" col-md-2" for="vat_number">VAT Number:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="vat_number" name="vat_number" value="{{ $user->vat_number }}">
                            </div>
                        </div>

                        @if($user->isSales())
                            <div class="form-group">
                                <label class=" col-md-2" for="commission">Commission(%):</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="commission" name="commission" value="{{ $user->commission }}">
                                </div>
                            </div>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <div class="form-group">
                                <label class="col-md-2" for="password">New Password:</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="password" name="password"
                                           value="">
                                    <p class="help-block">
                                        Current Password: {{ $user->password_text }}
                                    </p>
                                </div>
                                <label class="col-md-1" for="password_confirmation">Retype Password:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" value="">
                                </div>
                            </div>

                        @endif

                        <div class="form-group">
                            <label class="col-md-2" for="currency_id">Currency:</label>
                            <div class="col-md-3">
                                <select class="form-control lazySelector" id="currency_id" name="currency_id" data-selected="{{ $user->currency_id }}">
                                    <option value="">Choose Currency</option>
                                    {!! OptionsView(\App\Modules\Currencies\Currency::all(), 'id', 'name') !!}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">&nbsp;</label>
                            <div class="col-sm-8">
                                <input type="submit" value="Update User" class="btn btn-warning btn-sm submit-btn">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')

    <script>


    </script>
@stop