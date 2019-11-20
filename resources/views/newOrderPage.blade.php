@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
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
				<form action="{{ route('orders.create') }}" method="POST" role="form" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="title" class="col-md-4 col-form-label text-md-right">title</label>
						<div class="col-md-6">
							<input id="title" type="text" class="form-control" name="title"
										 value="{{ old('title') }}">
						</div>
					</div>
					<div class="form-group row">
						<label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
						<div class="col-md-6">
												<textarea name="description" id="description" cols="30" rows="10">
													{{ old('description') }}
												</textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="image" class="col-md-4 col-form-label text-md-right">Image</label>
						<div class="col-md-6">
							<input id="image" type="file" class="form-control" name="image">
						</div>
					</div>
					<div class="form-group row mb-0 mt-5">
						<div class="col-md-8 offset-md-4">
							<button type="submit" class="btn btn-primary">Update Profile</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>


@endsection
