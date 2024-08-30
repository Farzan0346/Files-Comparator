<div>
    <x-slot name="head">
        <style>
            <?= \Jfcherng\Diff\DiffHelper::getStyleSheet(); ?>
        </style>
    </x-slot>
    <x-bootstrap.card>
        <x-bootstrap.form  method="submit">
            <div class="row">
                <div class="offset-lg-2 col-lg-4">
                    <x-bootstrap.form.input  label="Upload First XML File:" type="file" id="file1" name="file1" accept=".xml"></x-bootstrap.form.input>
                </div>
                <div class="col-lg-4">
                    <x-bootstrap.form.input  label="Upload Second XML File:" type="file" id="file2" name="file2" accept=".xml" ></x-bootstrap.form.input>
                </div>
            </div>
            <div class="row">
                <div class="mt-4 d-flex justify-content-end gap-2 align-items-center">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-md">Back</a>
                    <button type="submit" class="btn btn-primary btn-md">Compare</button>
                </div>
            </div>

        </x-bootstrap.form>
        @if($diff)
        <div class="mt-4 ">
            <h3>XML Diff:</h3>
            <div>{!! $diff !!}</div>
        </div>
    @endif


    </x-bootstrap.card>
</div>
