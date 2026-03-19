<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\AcademicExperienceRequest;
use App\Http\Requests\Settings\DatingHistoryRequest;
use App\Http\Requests\Settings\UpdateAboutRequest;
use App\Http\Requests\Settings\UpdatePasswordRequest;
use App\Http\Requests\Settings\UpdateProfileRequest;
use App\Http\Requests\Settings\WorkExperienceRequest;
use App\Services\Settings\SettingsService;

class SettingsController extends Controller {
  public function __construct(protected SettingsService $settingsService) {
  }

  public function index() {
    $userId = auth()->id();

    $sexes = $this->settingsService->getAllSexes();
    $isPrivate = $this->settingsService->isPrivate($userId);
    $relationshipStatuses = $this->settingsService->getAllRelationshipStatuses();
    $educationLevels = $this->settingsService->getAllEducationLevels();
    $employmentTypes = $this->settingsService->getAllEmploymentTypes();
    $userProfile = $this->settingsService->getUserProfile($userId);
    $workExperiences = $this->settingsService->getWorkExperiences($userId);
    $academicExperiences = $this->settingsService->getAcademicExperiences($userId);
    $datingHistories = $this->settingsService->getDatingHistories($userId);

    return view("pages.settings.index")
      ->with("sexes", $sexes)
      ->with("isPrivate", $isPrivate)
      ->with("relationshipStatuses", $relationshipStatuses)
      ->with("educationLevels", $educationLevels)
      ->with("employmentTypes", $employmentTypes)
      ->with("userProfile", $userProfile)
      ->with("workExperiences", $workExperiences)
      ->with("academicExperiences", $academicExperiences)
      ->with("datingHistories", $datingHistories);
  }

  public function updateProfile(UpdateProfileRequest $request) {
    $this->settingsService->updateProfile(
      $request->user()->id,
      $request->validated(),
    );

    return redirect()->route("settings.index")->with("success", "Profile updated successfully.");
  }

  public function updateAbout(UpdateAboutRequest $request) {
    $this->settingsService->updateAbout(
      $request->user()->id,
      $request->validated(),
    );

    return redirect()->route("settings.index")->with("success", "About information updated successfully.");
  }

  public function updatePassword(UpdatePasswordRequest $request) {
    $this->settingsService->updatePassword(
      $request->user()->id,
      $request->input("password"),
    );

    return redirect()->route("settings.index")->with("success", "Password updated successfully.");
  }

  public function updatePrivacy(\Illuminate\Http\Request $request) {
    $this->settingsService->updatePrivacy(
      $request->user()->id,
      $request->boolean('is_private'),
    );

    return redirect()->route("settings.index")->with("success", "Privacy settings updated successfully.");
  }

  public function storeWorkExperience(WorkExperienceRequest $request) {
    $this->settingsService->storeWorkExperience(
      $request->user()->id,
      $request->validated(),
    );

    return redirect()->route("settings.index")->with("success", "Work experience added successfully.");
  }

  public function updateWorkExperience(WorkExperienceRequest $request, int $workExperience) {
    $this->settingsService->updateWorkExperience(
      $workExperience,
      $request->user()->id,
      $request->validated(),
    );

    return redirect()->route("settings.index")->with("success", "Work experience updated successfully.");
  }

  public function destroyWorkExperience(int $workExperience) {
    $this->settingsService->deleteWorkExperience($workExperience, auth()->id());

    return redirect()->route("settings.index")->with("success", "Work experience removed successfully.");
  }

  public function storeAcademicExperience(AcademicExperienceRequest $request) {
    $this->settingsService->storeAcademicExperience(
      $request->user()->id,
      $request->validated(),
    );

    return redirect()->route("settings.index")->with("success", "Academic experience added successfully.");
  }

  public function updateAcademicExperience(AcademicExperienceRequest $request, int $academicExperience) {
    $this->settingsService->updateAcademicExperience(
      $academicExperience,
      $request->user()->id,
      $request->validated(),
    );

    return redirect()->route("settings.index")->with("success", "Academic experience updated successfully.");
  }

  public function destroyAcademicExperience(int $academicExperience) {
    $this->settingsService->deleteAcademicExperience($academicExperience, auth()->id());

    return redirect()->route("settings.index")->with("success", "Academic experience removed successfully.");
  }

  public function storeDatingHistory(DatingHistoryRequest $request) {
    $this->settingsService->storeDatingHistory(
      $request->user()->id,
      $request->validated(),
    );

    return redirect()->route("settings.index")->with("success", "Dating history added successfully.");
  }

  public function updateDatingHistory(DatingHistoryRequest $request, int $datingHistory) {
    $this->settingsService->updateDatingHistory(
      $datingHistory,
      $request->user()->id,
      $request->validated(),
    );

    return redirect()->route("settings.index")->with("success", "Dating history updated successfully.");
  }

  public function destroyDatingHistory(int $datingHistory) {
    $this->settingsService->deleteDatingHistory($datingHistory, auth()->id());

    return redirect()->route("settings.index")->with("success", "Dating history removed successfully.");
  }
}
