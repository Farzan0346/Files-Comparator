<div>

    <x-bootstrap.card>
        <x-bootstrap.form method="store" >

            <div class="row my-3">
                <div class="col-lg-6">
                    <x-bootstrap.form.input :col="false" name="first_name" :wire="true"
                        label="First Name"></x-bootstrap.form.input>
                </div>
                <div class="col-lg-6">
                    <x-bootstrap.form.input :col="false" name="last_name" :wire="true" label="Last Name"></x-bootstrap.form.input>
                </div>
            </div>


            <div class="row my-3">
                <div class="col-lg-6">
                    <x-bootstrap.form.input type="email" :col="false" :wire="true" name="email"
                        label="Email Address"></x-bootstrap.form.input>
                </div>
                <div class="col-lg-6">
                    <x-bootstrap.form.input type="password" :col="false" :wire="true" name="password"
                        label="Password"></x-bootstrap.form.input>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-lg-6">
                    <x-bootstrap.form.input type="text" :col="false" :wire="true" name="phone"
                        label="Contact Number"></x-bootstrap.form.input>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-3 align-items-center" >
                <x-bootstrap.button size="md"  color="secondary" href="{{ route('org.dashboard') }}">Back</x-bootstrap.button>
                <x-bootstrap.form.button action="" :col="false">Submit</x-bootstrap.form.button>
            </div>
        </x-bootstrap.form>

    </x-bootstrap.card>
</div>
