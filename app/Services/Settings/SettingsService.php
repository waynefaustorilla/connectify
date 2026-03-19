<?php

namespace App\Services\Settings;

use App\Models\AcademicExperience;
use App\Models\DatingHistory;
use App\Models\EducationLevel;
use App\Models\EmploymentType;
use App\Models\RelationshipStatus;
use App\Models\Sex;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserSetting;
use App\Models\WorkExperience;
use Illuminate\Support\Facades\Hash;

class SettingsService {
  public function __construct(
    protected User $user,
    protected Sex $sex,
    protected UserSetting $userSetting,
    protected UserProfile $userProfile,
    protected WorkExperience $workExperience,
    protected AcademicExperience $academicExperience,
    protected DatingHistory $datingHistory,
  ) {
  }

  public function getAllSexes() {
    return $this->sex->getAllSexes();
  }

  public function getAllRelationshipStatuses() {
    return RelationshipStatus::all();
  }

  public function getAllEducationLevels() {
    return EducationLevel::all();
  }

  public function getAllEmploymentTypes() {
    return EmploymentType::all();
  }

  public function getUserProfile(int $userId): ?UserProfile {
    return $this->userProfile->with('relationshipStatus')->where('user_id', $userId)->first();
  }

  public function updateAbout(int $userId, array $data): UserProfile {
    return $this->userProfile->updateOrCreate(
      ['user_id' => $userId],
      [
        'bio' => $data['bio'],
        'hometown' => $data['hometown'],
        'current_city' => $data['current_city'],
        'website' => $data['website'],
        'relationship_status_id' => $data['relationship_status_id'],
      ],
    );
  }

  public function getWorkExperiences(int $userId) {
    return $this->workExperience->with('employmentType')->where('user_id', $userId)->orderByDesc('start_date')->get();
  }

  public function storeWorkExperience(int $userId, array $data): WorkExperience {
    return $this->workExperience->create([
      'user_id' => $userId,
      'company_name' => $data['company_name'],
      'job_title' => $data['job_title'],
      'employment_type_id' => $data['employment_type_id'],
      'start_date' => $data['start_date'],
      'end_date' => $data['end_date'],
      'description' => $data['description'],
      'is_current' => $data['is_current'] ?? false,
    ]);
  }

  public function updateWorkExperience(int $id, int $userId, array $data): WorkExperience {
    $experience = $this->workExperience->where('id', $id)->where('user_id', $userId)->firstOrFail();

    $experience->update([
      'company_name' => $data['company_name'],
      'job_title' => $data['job_title'],
      'employment_type_id' => $data['employment_type_id'],
      'start_date' => $data['start_date'],
      'end_date' => $data['end_date'],
      'description' => $data['description'],
      'is_current' => $data['is_current'] ?? false,
    ]);

    return $experience;
  }

  public function deleteWorkExperience(int $id, int $userId): void {
    $this->workExperience->where('id', $id)->where('user_id', $userId)->firstOrFail()->delete();
  }

  public function getAcademicExperiences(int $userId) {
    return $this->academicExperience->with('educationLevel')->where('user_id', $userId)->orderByDesc('start_year')->get();
  }

  public function storeAcademicExperience(int $userId, array $data): AcademicExperience {
    return $this->academicExperience->create([
      'user_id' => $userId,
      'school_name' => $data['school_name'],
      'education_level_id' => $data['education_level_id'],
      'field_of_study' => $data['field_of_study'],
      'start_year' => $data['start_year'],
      'end_year' => $data['end_year'],
      'description' => $data['description'],
    ]);
  }

  public function updateAcademicExperience(int $id, int $userId, array $data): AcademicExperience {
    $experience = $this->academicExperience->where('id', $id)->where('user_id', $userId)->firstOrFail();

    $experience->update([
      'school_name' => $data['school_name'],
      'education_level_id' => $data['education_level_id'],
      'field_of_study' => $data['field_of_study'],
      'start_year' => $data['start_year'],
      'end_year' => $data['end_year'],
      'description' => $data['description'],
    ]);

    return $experience;
  }

  public function deleteAcademicExperience(int $id, int $userId): void {
    $this->academicExperience->where('id', $id)->where('user_id', $userId)->firstOrFail()->delete();
  }

  public function getDatingHistories(int $userId) {
    return $this->datingHistory->where('user_id', $userId)->orderByDesc('start_date')->get();
  }

  public function storeDatingHistory(int $userId, array $data): DatingHistory {
    return $this->datingHistory->create([
      'user_id' => $userId,
      'partner_name' => $data['partner_name'],
      'start_date' => $data['start_date'],
      'end_date' => $data['end_date'],
      'description' => $data['description'],
    ]);
  }

  public function updateDatingHistory(int $id, int $userId, array $data): DatingHistory {
    $history = $this->datingHistory->where('id', $id)->where('user_id', $userId)->firstOrFail();

    $history->update([
      'partner_name' => $data['partner_name'],
      'start_date' => $data['start_date'],
      'end_date' => $data['end_date'],
      'description' => $data['description'],
    ]);

    return $history;
  }

  public function deleteDatingHistory(int $id, int $userId): void {
    $this->datingHistory->where('id', $id)->where('user_id', $userId)->firstOrFail()->delete();
  }

  public function updateProfile(int $userId, array $data): User {
    $user = $this->user->findOrFail($userId);

    $user->update([
      'firstname' => $data['firstname'],
      'middlename' => $data['middlename'],
      'lastname' => $data['lastname'],
      'username' => $data['username'],
      'email' => $data['email'],
      'sex_id' => $data['sex_id'],
      'birthdate' => $data['birthdate'],
    ]);

    return $user;
  }

  public function updatePassword(int $userId, string $password): void {
    $user = $this->user->findOrFail($userId);

    $user->update([
      'password' => $password,
    ]);
  }

  public function checkCurrentPassword(int $userId, string $password): bool {
    $user = $this->user->findOrFail($userId);

    return Hash::check($password, $user->password);
  }

  public function updatePrivacy(int $userId, bool $isPrivate): void {
    $this->userSetting->updateOrCreate(
      ['user_id' => $userId],
      ['is_private' => $isPrivate],
    );
  }

  public function isPrivate(int $userId): bool {
    $setting = $this->userSetting->where('user_id', $userId)->first();

    return $setting ? $setting->is_private : false;
  }
}
