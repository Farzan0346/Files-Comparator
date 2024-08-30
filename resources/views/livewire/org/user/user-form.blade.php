<div>

    <x-bootstrap.card>
        <x-bootstrap.form :method="$mode === 'edit' ? 'update' : 'save'">
            <div class="row">
                <div class="col-lg-6 my-3">
                    <x-bootstrap.form.input type="text" name="first_name"
                        label="Your First Name"></x-bootstrap.form.input>
                </div>
                <div class="col-lg-6 my-3">
                    <x-bootstrap.form.input type="text" name="last_name"
                        label="Your Last Name"></x-bootstrap.form.input>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 my-3">
                    <x-bootstrap.form.input type="email" name="email"
                        label="Email Address"></x-bootstrap.form.input>
                </div>
                <div class="col-lg-6 my-3">
                    <x-bootstrap.form.input type="password" name="password" label="Password"></x-bootstrap.form.input>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 my-3">
                    <x-bootstrap.form.input type="phone" name="phone"
                        label="Contact Number"></x-bootstrap.form.input>
                </div>
                <div class="mt-4 d-flex justify-content-end gap-2 align-items-center">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-md">Back</a>
                    <button type="submit" class="btn btn-primary btn-md">Submit</button>
                </div>
            </div>

        </x-bootstrap.form>
    </x-bootstrap.card>
</div>
