<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try {
            // Fetch authenticated user with relevant relationships
            $user = User::with([
                'addresses',
                'phoneNumbers',
                'insurances'
            ])->findOrFail(Auth::id());

            // Log dashboard access
            Log::info('Dashboard accessed', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip()
            ]);

            // Calculate profile completion
            $profileCompletion = $this->calculateProfileCompletion($user);

            // Prepare dashboard data
            $dashboardData = [
                'user' => $user,
                'profileCompletion' => $profileCompletion,
                'recentActivity' => $this->getRecentActivity($user),
            ];

            return view('dashboard', $dashboardData);
            
        } catch (\Exception $e) {
            Log::error('Dashboard access error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->route('login')
                ->with('error', 'Unable to load dashboard. Please try again.');
        }
    }

    /**
     * Update user dashboard preferences
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePreferences(Request $request)
    {
        $request->validate([
            'dashboard_layout' => 'nullable|string',
            'widget_preferences' => 'nullable|array'
        ]);

        try {
            $user = Auth::user();
            
            // Update user preferences
            $user->dashboard_preferences = [
                'layout' => $request->input('dashboard_layout'),
                'widgets' => $request->input('widget_preferences', [])
            ];
            $user->save();

            return response()->json([
                'message' => 'Dashboard preferences updated successfully',
                'preferences' => $user->dashboard_preferences
            ]);

        } catch (\Exception $e) {
            Log::error('Dashboard preferences update error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Unable to update preferences',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent user activity
     *
     * @param User $user
     * @return array
     */
    protected function getRecentActivity(User $user)
    {
        // Implement your logic to fetch recent activity
        // This is a placeholder - customize based on your needs
        return [];
    }

    /**
     * Calculate profile completion percentage
     *
     * @param User $user
     * @return int
     */
    protected function calculateProfileCompletion(User $user)
    {
        $totalFields = 0;
        $completedFields = 0;

        // Basic Information
        $basicFields = ['first_name', 'last_name', 'email', 'date_of_birth'];
        foreach ($basicFields as $field) {
            $totalFields++;
            if (!empty($user->$field)) {
                $completedFields++;
            }
        }

        // Addresses
        $totalFields++;
        if ($user->addresses->isNotEmpty()) {
            $completedFields++;
        }

        // Phone Numbers
        $totalFields++;
        if ($user->phoneNumbers->isNotEmpty()) {
            $completedFields++;
        }

        // Insurance Information
        $totalFields++;
        if ($user->insurances->isNotEmpty()) {
            $completedFields++;
        }

        return ($completedFields / $totalFields) * 100;
    }
}