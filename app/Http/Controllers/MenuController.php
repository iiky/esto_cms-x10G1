<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Menu;
use App\Models\PermissionGroup;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('Menu Access'), 403);
        $this->data['menus'] = Menu::all();
        
        return view('menu.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('Menu Create'), 403);

        $this->data['menus'] = Menu::all();
        $this->data['permissiongroups'] = PermissionGroup::all(); 
        $this->data['action'] = "/menu";
        return view('menu.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        abort_if(Gate::denies('Menu Create'), 403);

        Menu::create($request->all());

        return redirect('/menu')->with('success', 'New menu has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        abort_if(Gate::denies('Menu Update'), 403);

        $this->data['menus'] = Menu::all();
        $this->data['permissiongroups'] = PermissionGroup::all(); 
        $this->data['menu_data'] = $menu;
        $this->data['action'] = "/menu/".$menu->id;
        return view('menu.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        abort_if(Gate::denies('Menu Update'), 403);

        Menu::find($menu->id)
            ->update($request->all());

        return redirect('/menu')->with('success', 'Menu has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        abort_if(Gate::denies('Menu Delete'), 403);

        Menu::destroy($menu->id);
        return redirect('/menu')->with('success', 'Menu has been deleted!');
    }
}
