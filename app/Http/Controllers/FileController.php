<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    public function uploadFile(Request $request, $id)
    {
        $validator = Validator($request->all(), [
            'for' => 'required|string|in:project,task',
            'file_name' => 'required|string',
            'file' => 'required|file',
        ]);

        if (!$validator->fails()) {
            if ($request->input('for') == 'project') {
                $project = Project::withTrashed()->findOrFail($id);
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
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function projectDestory($id, File $file)
    {
        $project = Project::withTrashed()->findOrFail($id);
        if ($project->hasFile($file)) {
            return $this->deleteFile($file);
        }
        return abort(404);
    }

    public function taskDestory($project, Task $task, File $file) {
        $project = Project::withTrashed()->findOrFail($project);
        if($task->project_id != $project->id) return abort(404);
        if($task->hasFile($file)) return $this->deleteFile($file);
        return abort(404);
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
