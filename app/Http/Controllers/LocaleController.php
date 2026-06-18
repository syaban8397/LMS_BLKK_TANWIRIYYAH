<?php



namespace App\Http\Controllers;



use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;



class LocaleController extends Controller

{

    protected array $supported = ['id', 'en'];



    public function switch(Request $request, string $locale): RedirectResponse

    {

        if (! in_array($locale, $this->supported, true)) {

            $locale = 'id';

        }



        $request->session()->put('locale', $locale);

        $request->session()->save();



        $target = url()->previous();

        if (! $target || str_contains($target, '/locale/')) {

            $target = $request->user()

                ? route($request->user()->role . '.dashboard')

                : route('login');

        }



        return redirect()

            ->to($target)

            ->withHeaders([

                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',

                'Pragma' => 'no-cache',

            ]);

    }

}

