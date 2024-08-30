<?php

namespace App\Livewire\Org\profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileForm extends Component
{

    use WithFileUploads;

    /**
     * Collections
     */
    public $genders, $users;

    /**
     * Form fields
     */
    public $first_name, $last_name, $email, $password , $phone;

    public function mount()
    {
        $this->first_name = Auth::user()->first_name;
        $this->last_name = Auth::user()->last_name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone;
        $this->users = User::where('id', '!=', Auth::id())->get();
    }

    protected function rules()
    {
        return [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'phone' => 'required|max:100',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ];
    }

    public function render()
    {
        return view('livewire.org.profile.profile-form');
    }

    public function store()
    {
        $this->validate();

        $user = Auth::user();

        $user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password ? Hash::make($this->password) : $user->password,
        ]);

        return redirect()->route('org.dashboard');
    }
}
