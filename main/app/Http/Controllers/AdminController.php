<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function login(): View|RedirectResponse
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.settings');
        }

        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $username = Setting::valueFor('admin_username', env('ADMIN_USERNAME', 'admin'));
        $passwordHash = Setting::valueFor('admin_password_hash');
        $passwordIsValid = $passwordHash
            ? Hash::check($credentials['password'], $passwordHash)
            : $credentials['password'] === env('ADMIN_PASSWORD', 'admin123');

        if ($credentials['username'] !== $username || ! $passwordIsValid) {
            return back()->withErrors(['username' => 'Invalid admin username or password.'])->onlyInput('username');
        }

        $request->session()->regenerate();
        session(['admin_logged_in' => true]);

        return redirect()->route('admin.settings');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_logged_in');
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function settings(): View|RedirectResponse
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $defaults = PortfolioController::defaults();
        $settings = [];

        foreach ($defaults as $key => $value) {
            $settings[$key] = Setting::valueFor($key, $value);
        }

        $settings['admin_username'] = Setting::valueFor('admin_username', env('ADMIN_USERNAME', 'admin'));
        $views = (int) Setting::valueFor('portfolio_views', 0);
        $messages = ContactMessage::query()->latest()->limit(25)->get();
        $totalMessages = ContactMessage::query()->count();
        $unreadMessages = ContactMessage::query()->where('is_read', false)->count();

        return view('admin.settings', compact('settings', 'views', 'messages', 'totalMessages', 'unreadMessages'));
    }

    public function update(Request $request): RedirectResponse
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'role' => ['required', 'string', 'max:160'],
            'hero_title' => ['required', 'string', 'max:220'],
            'summary' => ['required', 'string'],
            'location' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:40'],
            'github' => ['required', 'url', 'max:255'],
            'linkedin' => ['required', 'url', 'max:255'],
            'relocation' => ['nullable', 'string', 'max:180'],
            'stats' => ['required', 'string'],
            'skills' => ['required', 'string'],
            'experience' => ['required', 'string'],
            'project_title' => ['required', 'string', 'max:160'],
            'project_description' => ['required', 'string'],
            'project_tags' => ['required', 'string', 'max:255'],
            'project_points' => ['required', 'string'],
            'education' => ['required', 'string'],
            'seo_title' => ['required', 'string', 'max:160'],
            'seo_description' => ['required', 'string', 'max:300'],
            'seo_keywords' => ['required', 'string', 'max:500'],
            'certificates' => ['required', 'string'],
            'new_certificate_title' => ['nullable', 'string', 'max:120'],
            'new_certificate_image' => ['nullable', 'image', 'max:4096'],
            'resume_pdf' => ['required', 'string', 'max:255'],
            'resume_file' => ['nullable', 'file', 'mimes:pdf', 'max:8192'],
            'resume_previews' => ['required', 'string'],
            'resume_preview_files' => ['nullable', 'array'],
            'resume_preview_files.*' => ['image', 'max:4096'],
            'admin_username' => ['required', 'string', 'max:80'],
            'admin_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if ($request->hasFile('new_certificate_image')) {
            $title = $data['new_certificate_title'] ?: 'Certificate';
            $path = $this->storePublicUpload($request->file('new_certificate_image'), 'uploads/certificates');
            $data['certificates'] = trim($data['certificates']) . "\n{$title}|{$path}";
        }

        if ($request->hasFile('resume_file')) {
            $data['resume_pdf'] = $this->storePublicUpload($request->file('resume_file'), 'uploads/resume');
        }

        if ($request->hasFile('resume_preview_files')) {
            $previewPaths = [];

            foreach ($request->file('resume_preview_files') as $file) {
                $previewPaths[] = $this->storePublicUpload($file, 'uploads/resume');
            }

            $data['resume_previews'] = implode("\n", $previewPaths);
        }

        foreach (PortfolioController::defaults() as $key => $default) {
            Setting::put($key, $data[$key] ?? '');
        }

        Setting::put('admin_username', $data['admin_username']);

        if (! empty($data['admin_password'])) {
            Setting::put('admin_password_hash', Hash::make($data['admin_password']));
        }

        return back()->with('success', 'Settings saved successfully.');
    }

    private function storePublicUpload($file, string $directory): string
    {
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = ($filename ?: 'upload') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $target = public_path($directory);

        if (! is_dir($target)) {
            mkdir($target, 0775, true);
        }

        $file->move($target, $filename);

        return trim($directory . '/' . $filename, '/');
    }
}
