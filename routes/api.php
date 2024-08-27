<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\EducateController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\ContactMeController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\ResumeController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::get("/me",[ProfileController::class,'index']);
Route::get("/allEducations",[EducateController::class,'index']);
Route::get("/showEducate/{educate}",[EducateController::class,'show']);
Route::get("/jobs",[JobController::class,'index']);
Route::get("/showJob/{job}",[JobController::class,'show']);
Route::get("/skills",[SkillController::class,'index']);
Route::get("/certificates",[CertificateController::class,'index']);
Route::get("/showCertificate/{certificate}",[CertificateController::class,'show']);
Route::get("/projects",[ProjectController::class,'index']);
Route::get("/showProject/{project}",[ProjectController::class,'show']);
Route::get("/media",[MediaController::class,'index']);
Route::get("/services",[ServiceController::class,'index']);
Route::get("/resume/{resume}",[ResumeController::class,'index']);
Route::get("/myInformation",[InformationController::class,'index']);

Route::middleware('auth:sanctum')->group(function(){

    Route::post('/logout',[AuthController::class,'logout']);

    Route::post("/storeInfo",[ProfileController::class,'store']);
    Route::put("/updateInfo/{profile}",[ProfileController::class,'update']);
    Route::delete("/deleteInfo/{profile}",[ProfileController::class,'destroy']);

    Route::post("/storeEducation",[EducateController::class,'store']);
    Route::put("/updateEducate/{educate}",[EducateController::class,'update']);
    Route::delete("/deleteEducate/{educate}",[EducateController::class,'destroy']);

    Route::post("/storeJob",[JobController::class,'store']);
    Route::put("/updateJob/{job}",[JobController::class,'update']);
    Route::delete("/deleteJob/{job}",[JobController::class,'destroy']);

    Route::post("/storeSkill",[SkillController::class,'store']);
    Route::put("/updateSkill/{skill}",[SkillController::class,'update']);
    Route::delete("/deleteSkill/{skill}",[SkillController::class,'destroy']);

    Route::post("/storeCertificate",[CertificateController::class,'store']);
    Route::put("/updateCertificate/{certificate}",[CertificateController::class,'update']);
    Route::delete("/deleteCertificate/{certificate}",[CertificateController::class,'destroy']);

    Route::post("/storeProject",[ProjectController::class,'store']);
    Route::put("/updateProject/{project}",[ProjectController::class,'update']);
    Route::delete("/deleteProject/{project}",[ProjectController::class,'destroy']);

    Route::post("/storeMessage",[ContactMeController::class,'store']);
    Route::put("/updateMessage/{message}",[ContactMeController::class,'update']);
    Route::delete("/deleteMessage/{message}",[ContactMeController::class,'destroy']);
    Route::get("/messages",[ContactMeController::class,'index']);
    Route::get("/showMessage/{message}",[ContactMeController::class,'show']);

    Route::post("/storeMedia",[MediaController::class,'store']);
    Route::put("/updateMedia/{media}",[MediaController::class,'update']);
    Route::delete("/deleteMedia/{media}",[MediaController::class,'destroy']);

    Route::post("/storeService",[ServiceController::class,'store']);
    Route::put("/updateService/{service}",[ServiceController::class,'update']);
    Route::delete("/deleteService/{service}",[ServiceController::class,'destroy']);

    Route::post("/storeResume",[ResumeController::class,'store']);
    Route::put("/updateResume/{resume}",[ResumeController::class,'update']);
    Route::delete("/deleteResume/{resume}",[ResumeController::class,'destroy']);

    Route::post("/storeInformation",[InformationController::class,'store']);
    Route::put("/edit/{information}",[InformationController::class,'update']);
    Route::delete("/deleteInformation/{information}",[InformationController::class,'destroy']);


});
