<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSection\Project\UploadFileRequest;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    public function index() {
        $files = File::with('uploadedBy')
            ->where('uploaded_by', auth()->user()->id)
            ->orderBy('id', 'DESC')->paginate(25);
            
            return response()->view('crm.pages.my.files.index', compact('files'));
    }

    public function uploadFile($id, UploadFileRequest $request)
    {
        if ($request->input('for') == 'project') {
            $project = Project::withTrashed()->findOrFail($id);
            if ($project->user_id != auth()->user()->id) {
                return abort(Response::HTTP_NOT_FOUND);
            }
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . rand(1, 1000000) . '.' . $file->getClientOriginalExtension();
                $path = $file->storePubliclyAs('crm/files/projects', $fileName, ['disk' => 'public']);
                $uploaded = $project->files()->create([
                    'name' => $request->input('file_name'),
                    'path' => $path,
                    'uploaded_by' => auth()->user()->id
                ]);
                return response()->json([
                    'message' => $uploaded ? 'File Uploaded Successfully!' : 'Failed to upload file',
                ], $uploaded ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
            }
        } else {
            $task = Task::findOrFail($id);
            if ($task->user_id != auth()->user()->id && $task->project->user_id != auth()->user()->id) {
                return abort(Response::HTTP_NOT_FOUND);
            }
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . rand(1, 1000000) . '.' . $file->getClientOriginalExtension();
                $path = $file->storePubliclyAs('crm/files/tasks', $fileName, ['disk' => 'public']);
                $uploaded = $task->files()->create([
                    'name' => $request->input('file_name'),
                    'path' => $path,
                    'uploaded_by' => auth()->user()->id
                ]);
                return response()->json([
                    'message' => $uploaded ? 'File Uploaded Successfully!' : 'Failed to upload file',
                ], $uploaded ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
            }
        }
    }

    public function projectDestory(Project $project, File $file)
    {
        if ($project->user_id != auth()->user()->id) return abort(Response::HTTP_NOT_FOUND);
        if ($project->hasFile($file)) return $this->deleteFile($file);
        return abort(Response::HTTP_NOT_FOUND);
    }

    public function taskDestory(Project $project, Task $task, File $file)
    {
        if ($task->project_id != $project->id) return abort(Response::HTTP_NOT_FOUND);
        if ($task->user_id != auth()->user()->id && $project->user_id != auth()->user()->id) return abort(Response::HTTP_NOT_FOUND);
        if ($task->hasFile($file)) return $this->deleteFile($file);
        return abort(Response::HTTP_NOT_FOUND);
    }

    protected function deleteFile(File $file)
    {
        $deleted = $file->delete();
        if ($deleted) {
            Storage::disk('public')->delete('' . $file->path);
        }
        return response()->json([
            'icon' => $deleted ? 'success' : 'error',
            'title' => $deleted ? 'Deleted!' : 'Failed',
            'text' => $deleted ? 'File Deleted Successfully!' : 'Failed to delete the file, Please try again',
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
