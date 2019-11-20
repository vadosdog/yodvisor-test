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
				@foreach($orders as $order)
					<div class="card">
						<div class="card-header">{{ $order->title }}</div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-12">
										<form action="{{ route('orders.update', ['order' => $order->id]) }}" method="POST" role="form"
													enctype="multipart/form-data">
											@csrf
											<div class="form-group row">
												<label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
												<div class="col-md-6">
													{{ $order->title }}
												</div>
											</div>
											<div class="form-group row">
												<label for="description"
															 class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
												<div class="col-md-6">
													{{ $order->description }}
												</div>
											</div>
											@isset($order->image)
												<div class="form-group row">
													<label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
													<div class="col-md-6">
														<img src="{{ $order->imageUrl }}" alt="{{ $order->title }}" class="rounded"
																 style="max-width: 500px">{{-- знаю что плохо, но не хочу со стилями возиться --}}
													</div>
												</div>
											@endisset
											<div class="form-group row">
												<label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
												<div class="col-md-6">
													@if ($order->isEditable())
														{!! Form::select('status', $statuses, $order->status, [
															"name"=>"status",
															"id"=>"status",
															"class"=>"form-control"
														]); !!}
													@else
														<div class="col-form-label">
															{{ $statuses[$order->status] }}
														</div>
													@endif
												</div>
											</div>
											<div class="form-group row">
												<label for="description"
															 class="col-md-4 col-form-label text-md-right">{{ __('Comment') }}</label>
												<div class="col-md-6">
													@if ($order->isEditable())
														<textarea class="form-control" name="description" id="description" cols="30"
																			rows="10">{{ old('comment') ?? $order->comment  }}</textarea>
													@else
														<div class="col-form-label">
															{{ $order->comment }}
														</div>
													@endif
												</div>
											</div>
											@if ($order->isEditable())
												<div class="form-group row mb-0 mt-5">
													<div class="col-md-8 offset-md-4">
														<button type="submit" class="btn btn-primary">{{ __('Update Order') }}</button>
													</div>
												</div>
											@endif
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>


@endsection
