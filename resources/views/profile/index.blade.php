@extends('layouts.app')


@section('content')

    <main class="py-16 lg:py-20">
        <div class="container">

            <section>
                <!-- Section heading -->
                <h1 class="mb-8 text-lg lg:text-[42px] font-black text-center">Редактировать профиль</h1>
                <div class="max-w-[640px] mt-12 mx-auto p-6 xs:p-8 md:p-12 2xl:p-16 rounded-[20px] bg-purple">
                    <form action="{{ route('profile.update', $user) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <x-forms.text-input
                            name="name"
                            type="text"
                            placeholder="Имя и фамилия"
                            value="{{ $user->name }}"
                            :isError="$errors->has('name')"
                        >
                        </x-forms.text-input>
                        @error('name')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                        @enderror
                        <x-forms.text-input
                            name="email"
                            type="text"
                            placeholder="E-mail"
                            value="{{ $user->email }}"
                            :isError="$errors->has('email')"
                        >
                        </x-forms.text-input>
                        @error('email')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                        @enderror
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <x-forms.text-input
                                type="password"
                                name="password"
                                placeholder="Пароль"
                                :isError="$errors->has('password')"
                            >
                            </x-forms.text-input>
                            @error('password')
                            <x-forms.error>
                                {{ $message }}
                            </x-forms.error>
                            @enderror

                            <x-forms.text-input
                                type="password"
                                name="password_confirmation"
                                placeholder="Повторите пароль"
                                :isError="$errors->has('password-confirmation')"
                            >
                            </x-forms.text-input>
                            @error('password-confirmation')
                            <x-forms.error>
                                {{ $message }}
                            </x-forms.error>
                            @enderror
                        </div>
                        <button type="submit" class="w-full btn btn-pink">Сохранить</button>
                    </form>
                </div>

            </section>

        </div>
    </main>

@endsection
