<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Opd;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class Form extends Component
{
    public $userId, $name, $email, $nowa, $opd_id, $password, $role = 'user', $active = '1';
    public $listOpd = [];
    public $isLoading = false;

    public function mount($id = null)
    {
        $this->listOpd = Opd::orderBy('id')->get();

        if ($id) {
            try {
                $decryptedId = Crypt::decrypt($id);
                $user = User::findOrFail($decryptedId);
            } catch (\Exception $e) {
                session()->flash('error', 'Invalid User ID');
                return redirect()->route('users.index');
            }
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->nowa = $user->nowa;
            $this->opd_id = $user->opd_id;
            $this->role = $user->role;
            $this->active = $user->active;
        }
    }

    public function updatedEmail($value)
    {
        $exists = User::where('email', $value)
            ->when($this->userId, fn($q) => $q->where('id', '!=', $this->userId))
            ->exists();

        if ($exists) {
            $this->addError('email', 'Email sudah digunakan.');
        } else {
            $this->resetErrorBag('email');
        }
    }

    public function save()
    {
        $this->isLoading = true;

        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => $this->userId ? 'nullable|min:8' : 'required|min:8',
            'role' => 'required|in:superadmin,penilai,user,viewer',
            'active' => 'required|in:1,0',
        ]);

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'nowa' => $this->normalizePhoneNumber($this->nowa),
                'role' => $this->role,
                'opd_id' => $this->opd_id,
                'active' => $this->active,
                'password' => $this->password ? Hash::make($this->password) : $user->password,
            ]);
            session()->flash('message', 'Data berhasil diperbarui.');
            return redirect()->route('users.index');
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'nowa' => $this->normalizePhoneNumber($this->nowa),
                'opd_id' => $this->opd_id,
                'active' => $this->active,
                'password' => Hash::make($this->password),
            ]);
            $this->reset(['name', 'email', 'password', 'role', 'opd_id', 'active']);
            $this->dispatch('show-toast', message: 'Data berhasil ditambahkan.');
        }

        $this->isLoading = false;
    }

    private function normalizePhoneNumber($number)
    {
        // Remove non-numeric characters
        $number = preg_replace('/\D/', '', $number);

        // Add country code if missing
        if (substr($number, 0, 1) == '0') {
            $number = '62' . substr($number, 1);
        }

        return $number;
    }

    public function render()
    {
        return view('livewire.users.form')
            ->layout('components.layouts.app', ['title' => $this->userId ? 'Edit User' : 'Tambah User']);
    }
}
