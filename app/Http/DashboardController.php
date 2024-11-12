<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance with authentication middleware
     */
    public function __construct()
    {
        // Ensure only authenticated users can access
        $this->middleware(['auth', 'active']);
    }

    /**
     * Show the application dashboard
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try {
            // Fetch authenticated user with all relationships
            $user = User::with([
                'addresses', 
                'phoneNumbers', 
                'appointments' => function($query) {
                    // Optional: Filter or limit appointments
                    $query->recent()->take(5);
                },
                'medicalRecords' => function($query) {
                    // Optional: Sort medical records
                    $query->latest()->take(3);
                },
                'insurances'
            ])->findOrFail(Auth::id());

            // Log dashboard access
            Log::info('Dashboard accessed', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip()
            ]);

            // Additional user profile completeness check
            $profileCompletion = $this->calculateProfileCompletion($user);

            // Prepare dashboard data
            $dashboardData = [
                'user' => $user,
                'profileCompletion' => $profileCompletion,
                'upcomingAppointments' => $user->appointments->take(3),
                'recentMedicalRecords' => $user->medicalRecords->take(2),
            ];

            return view('dashboard', $dashboardData);
        } catch (\Exception $e) {
            // Log error and redirect with message
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
}