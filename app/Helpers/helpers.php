<?php

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

if(!function_exists('menu'))
{
    function menu($menu = NULL)
    {
        $menu_array = array();
        if (is_null($menu)) {
            $menus = Menu::whereNull('menu_id')->where('status',true)->orderBy('sort')->get();
        } else {
            $menus = Menu::where([['menu_id', $menu->id],['status',true]])->orderBy('sort')->get();
        }

        foreach ($menus as $menu) {
            $data = array();
            if (!is_null($menu->permission_group_id)) {
                $permissions = $menu->permissiongroup ? $menu->permissiongroup->permissions : [];
                $data_permission = array();
                foreach ($permissions as $permission) {
                    $data_permission[] = $permission->name;
                }

                if (Auth::check() && Auth::user()->canany($data_permission)) {
                    $data['id'] = $menu->id;
                    $data['menu_id'] = $menu->menu_id;
                    $data['nama_menu'] = $menu->nama_menu;
                    $data['icon'] = $menu->icon;
                    $data['permission_group_id'] = $menu->permission_group_id;
                    $data['href'] = $menu->href;
                }
            } else {
                $data_child = array();
                if (isset($menu->child)) {
                    $data_array = menu($menu);
                    if (!is_null($data_array)) {
                        $data_child = menu($menu);
                    }
                }
                if (!empty($data_child)) {
                    $data['id'] = $menu->id;
                    $data['menu_id'] = $menu->menu_id;
                    $data['nama_menu'] = $menu->nama_menu;
                    $data['icon'] = $menu->icon;
                    $data['permission_group_id'] = $menu->permission_group_id;
                    $data['href'] = $menu->href;
                    $data['child'] = $data_child;
                }
            }

            if (!empty($data)) {
                $menu_array[] = $data;
                $data = array();
            }
        }

        if (!empty($menu_array)) {
            return $menu_array;
        } else {
            return NULL;
        }
    }
}

if(!function_exists('setting')){
    function setting($key, $default = null)
    {
        $all = settings();
        return $all[$key] ?? Setting::getValue($key, $default);
    }
}

if(!function_exists('settings')){
    function settings()
    {
        static $cachedSettings = null;
        if ($cachedSettings !== null) {
            return $cachedSettings;
        }

        $all = Setting::getAllSettings();

        $defaults = [
            'title'                 => 'ESTO CMS',
            'tagline'               => 'Portal Informasi & Content Management System',
            'company_name'          => 'PT. ESTO Solusi Media',
            'email'                 => 'info@estocms.com',
            'phone'                 => '+62 812-3456-7890',
            'address'               => 'Jakarta, Indonesia',
            'operating_hours'       => 'Senin - Jumat: 08:00 - 17:00 WIB',
            'logo'                  => asset('/assets/images/logo/logo.png'),
            'favicon'               => asset('/assets/images/favicon.png'),
            'meta_title'            => 'ESTO CMS - Solusi CMS Handal & Cepat',
            'description'           => 'ESTO CMS adalah platform manajemen konten terpadu yang dioptimalkan untuk performa cepat dan SEO tinggi.',
            'keyword'               => 'cms, portal berita, esto, media, indonesia',
            'author'                => 'ESTO CMS Team',
            'og_image'              => asset('/assets/images/logo/logo.png'),
            'robots_index'          => 'index, follow',
            'google_analytics_id'   => '',
            'google_search_console' => '',
            'facebook_url'          => '',
            'instagram_url'         => '',
            'twitter_url'           => '',
            'linkedin_url'          => '',
            'youtube_url'           => '',
            'custom_head_scripts'   => '',
            'custom_footer_scripts' => '',
        ];

        foreach ($defaults as $k => $def) {
            if (!isset($all[$k]) || $all[$k] === null || $all[$k] === '') {
                $all[$k] = $def;
            }
        }

        if (is_array($all['keyword'])) {
            $all['keyword'] = implode(', ', $all['keyword']);
        }

        $cachedSettings = $all;
        return $cachedSettings;
    }
}

if(!function_exists('clean_html')){
    function clean_html($html)
    {
        if (empty($html)) {
            return '';
        }
        // Bersihkan tag script, inline event handler (onload, onerror, dll), dan skema javascript:
        $clean = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        $clean = preg_replace('#\s*on\w+\s*=\s*(".*?"|\'.*?\'|[^\'">\s]+)#is', '', $clean);
        $clean = preg_replace('#href\s*=\s*["\']javascript:[^"\']*["\']#is', 'href="#"', $clean);
        return $clean;
    }
}
