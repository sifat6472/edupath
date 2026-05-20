<?php
namespace App\Http\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Repositories\SavedItemRepository;
use App\Core\Database;

class ProfileController extends Controller
{
    public function index(): string
    {
        $auth = AuthService::getInstance();
        $user = $auth->user();
        $db = Database::getInstance();
        $preferences = $db->fetchOne("SELECT * FROM user_preferences WHERE user_id = ?", [$user['id']]);

        $savedRepo = new SavedItemRepository();
        $savedItems = $savedRepo->getUserSaved($user['id']);

        // Hydrate saved items
        $savedDetails = [];
        foreach ($savedItems as $s) {
            if ($s['item_type'] === 'program') {
                $detail = $db->fetchOne("SELECT p.*, u.name AS uni FROM programs p JOIN universities u ON u.id = p.university_id WHERE p.id = ?", [$s['item_id']]);
            } elseif ($s['item_type'] === 'scholarship') {
                $detail = $db->fetchOne("SELECT * FROM scholarships WHERE id = ?", [$s['item_id']]);
            } else {
                $detail = $db->fetchOne("SELECT * FROM professors WHERE id = ?", [$s['item_id']]);
            }
            if ($detail) {
                $detail['_type'] = $s['item_type'];
                $savedDetails[] = $detail;
            }
        }

        return $this->view('profile.index', [
            'title' => 'My Profile',
            'user' => $user,
            'preferences' => $preferences,
            'savedItems' => $savedDetails,
        ]);
    }
}
