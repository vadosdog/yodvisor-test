<?php

$statuses = [
	\App\Models\Order::STATUS_PENDING => __('Pending'),
	\App\Models\Order::STATUS_PROCESSING => __('Processing'),
	\App\Models\Order::STATUS_COMPLETED => __('Completed'),
	\App\Models\Order::STATUS_ON_HOLD => __('On Hold'),
	\App\Models\Order::STATUS_CANCELED => __('Canceled'),
];

?>

@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
				@endif
				@if ($errors->any())
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<ul>
							@foreach ($errors->all() as $error)
								<li>
									{{ $error }}
								</li>
							@endforeach
						</ul>
					</div>
				@endif

				<orders-list></orders-list>
			</div>
		</div>
	</div>


@endsection
