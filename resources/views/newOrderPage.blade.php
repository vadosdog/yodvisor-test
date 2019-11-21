@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">{{ __('Create Order') }}</div>
					<div class="card-body">
						<div class="container">
							<div class="row">
								<div class="col-12">
									<new-order-form></new-order-form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
