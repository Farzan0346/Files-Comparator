<div>
    {{-- Stop trying to control. --}}
    <x-bootstrap.card>
        <x-bootstrap.table :datatable="true">
            <x-slot name="head">
                <th>#</th>
                <th>Name</th>
                <th>Action</th>
            </x-slot>
            <x-slot name="body">
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="{{route('org.role.edit', ['role' => $role->id])}}">
                            <i class="las la-pen text-secondary fs-18" ></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-bootstrap.table>
    </x-bootstrap.card>
</div>
