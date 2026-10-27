<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Reparacion;
use App\Models\Foto;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TareasController extends Controller
{
    public function create($idReparacion)
    {
        $reparacion = Reparacion::with('vehiculo.cliente')->findOrFail($idReparacion);
        $trabajadores = User::where('Rol', 'trabajador')->get();

        return view('tareas.crearTareas', compact('reparacion', 'trabajadores'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'Descripcion'    => 'required|string',
            'Prioridad'      => 'required|in:alta,media,baja',
            'Estado'         => 'required|in:pendiente,en curso,terminada,revisada',
            'id_Reparacion'  => 'required|exists:reparaciones,id_Reparacion',
            'user_id'        => 'required|exists:users,user_id',
            'FechaProgramada'=> 'nullable|date',
            'HorasPrevistas' => 'nullable|numeric',
            'HorasReales'    => 'nullable|numeric',
            'Importe'        => 'nullable|numeric|min:0',
            'Observaciones'  => 'nullable|string',
        ]);

        // Autogenerar FechaRealizada si ya se marca como terminada
        if ($data['Estado'] === 'terminada') {
            $data['FechaRealizada'] = now();
        }

        $tarea = Tarea::create($data);

        // Para devolver el nombre del trabajador:
        $trabajador = $tarea->usuario ? $tarea->usuario->Nombre : "Sin asignar";

        return redirect()->route('editarReparaciones', $request->id_Reparacion)->with('success', 'Tarea creada correctamente.');

    }


    public function edit($id)
    {
        if (!session()->has('prev_url')) {
            session(['prev_url' => url()->previous()]);
        }
        
        $tarea = Tarea::with([
            'reparacion.vehiculo.cliente',
            'materiales',
            'fotos'
        ])->findOrFail($id);

        $trabajadores = User::where('Rol', 'trabajador')->get();

        return view('tareas.editarTareas', compact('tarea', 'trabajadores'));
    }


    public function update(Request $request, $id)
    {
        $tarea = Tarea::findOrFail($id);

        $data = $request->validate([
            'Descripcion'    => 'required|string',
            'Prioridad'      => 'required|in:alta,media,baja',
            'Estado'         => 'required|in:pendiente,en curso,terminada,revisada',
            'user_id'        => 'required|exists:users,user_id',
            'FechaProgramada'=> 'nullable|date',
            'HorasPrevistas' => 'nullable|numeric',
            'HorasReales'    => 'nullable|numeric',
            'Importe'        => 'nullable|numeric|min:0',
            'Observaciones'  => 'nullable|string',
        ]);

        if ($data['Estado'] === 'terminada' && !$tarea->FechaRealizada) {
            $data['FechaRealizada'] = now();
        }

        $tarea->update($data);

        return redirect()->back()->with('success', 'Tarea actualizada.');

    }


    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $idReparacion = $tarea->id_Reparacion;

        $tarea->delete();

        return redirect()->route('editarReparaciones', $idReparacion)->with('success', 'Tarea eliminada.');
    }


    public function misTareas()
    {
        session()->forget('prev_url');

        $user = Auth::user();

        if ($user->Rol === 'jefe') {
            $tareas = Tarea::orderBy('FechaProgramada')->get();
        } else {
            $tareas = Tarea::where('user_id', $user->user_id)->orderBy('FechaProgramada')->get();
        }

        // Agrupar por fecha
        $tareasPorDia = $tareas->groupBy(function($t){
            return $t->FechaProgramada ? \Carbon\Carbon::parse($t->FechaProgramada)->format('Y-m-d'): 'Sin fecha';
        });

        return view('tareas.misTareas', compact('tareasPorDia'));
    }


    public function actualizarEstado(Request $request, $id)
    {
        $tarea = Tarea::where('user_id', Auth::user()->user_id)->findOrFail($id);

        $request->validate([
            'Estado' => 'required|in:pendiente,en curso,terminada,revisada'
        ]);

        if ($request->Estado === 'terminada' && !$tarea->FechaRealizada) {
            $tarea->FechaRealizada = now();
        }

        $tarea->Estado = $request->Estado;
        $tarea->save();

        return back()->with('success', 'Estado actualizado.');
    }
    

    public function ver($id)
    {
        if (!session()->has('prev_url')) {
            session(['prev_url' => url()->previous()]);
        }

        $tarea = Tarea::with([
            'reparacion.vehiculo.cliente',
            'materiales',
            'fotos'
        ])->where('user_id', Auth::user()->user_id)->findOrFail($id);

        return view('tareas.ver', compact('tarea'));
    }


    public function actualizarTrabajador(Request $request, $id)
    {
        $tarea = Tarea::where('user_id', Auth::user()->user_id)->findOrFail($id);

        $data = $request->validate([
            'HorasReales' => 'nullable|numeric|min:0',
            'Estado' => 'required|in:pendiente,en curso,terminada,revisada',
            'Observaciones' => 'nullable|string',
        ]);

        if ($data['Estado'] === 'terminada' && !$tarea->FechaRealizada) {
            $data['FechaRealizada'] = now();
        }

        $tarea->update($data);

        return back()->with('success', 'Tarea actualizada correctamente.');
    }


    public function agregarMaterial(Request $request, $id)
    {
        $request->validate([
            'Descripcion' => 'required|string',
            'Cantidad' => 'required|integer|min:1',
            'Estado' => 'required|in:pedido,recibido,usado',
        ]);

        Material::create([
            'Descripcion' => $request->Descripcion,
            'Cantidad' => $request->Cantidad,
            'Estado' => $request->Estado,
            'id_Tarea' => $id,
        ]);

        return back()->with('success', 'Material añadido.');
    }


    public function eliminarMaterial($idMaterial)
    {
        $material = Material::findOrFail($idMaterial);
        $material->delete();

        return back()->with('success', 'Material eliminado.');
    }


    public function subirFoto(Request $request, $id)
    {
        $request->validate([
            'Tipo' => 'required|in:inicial,final',
            'foto' => 'required|image|max:4096'
        ]);

        $fotoAnterior = Foto::where('id_Tarea', $id)->where('Tipo', $request->Tipo)->first();

        if ($fotoAnterior) {
            Storage::disk('public')->delete($fotoAnterior->Url);
            $fotoAnterior->delete();
        }
        $path = $request->file('foto')->store('fotos', 'public');

        Foto::create([
            'Url' => $path,
            'Tipo' => $request->Tipo,
            'Fecha' => now(),
            'id_Tarea' => $id,
        ]);

        return back()->with('success', 'Foto actualizada correctamente.');
    }


    public function eliminarFoto($id)
    {
        $foto = Foto::findOrFail($id);

        Storage::disk('public')->delete($foto->Url);
        $foto->delete();

        return back()->with('success', 'Foto eliminada.');
    }


    public function descargarFoto($id)
    {
        $foto = Foto::findOrFail($id);

        $ruta = storage_path('app/public/' . $foto->Url);

        if (!file_exists($ruta)) {
            return back()->with('error', 'La imagen no existe en el servidor.');
        }

        $nombre = 'tarea_' . $foto->id_Tarea . '_' . $foto->Tipo . '.' . pathinfo($ruta, PATHINFO_EXTENSION);

        return response()->download($ruta, $nombre);
    }


    public function calendario()
    {
        if (auth()->user()->Rol === 'jefe') {
            $tareas = Tarea::with('reparacion.vehiculo')->get();
        } 
        else {
            $tareas = Tarea::with('reparacion.vehiculo')->where('user_id', auth()->user()->user_id)->get();
        }

        $eventos = $tareas->map(function ($t) {

            $vehiculo = $t->reparacion->vehiculo->Marca . " " . $t->reparacion->vehiculo->Modelo . " (" .  $t->reparacion->vehiculo->Matricula . ")";

            return [
                'id'     => $t->id_Tarea,
                'title'  => "{$t->Descripcion} — {$vehiculo}",
                'start'  => $t->FechaProgramada->format('Y-m-d'),
                'estado' => $t->Estado, 
                'color'  => match ($t->Prioridad) {
                    'alta'  => '#dc3545',
                    'media' => '#ffc107',
                    'baja'  => '#198754',
                    default => '#0d6efd'
                }
            ];
        });

        return view('tareas.calendario', compact('eventos'));
    }


    public function tareasTrabajador($id)
    {
        $trabajador = User::where('Rol', 'trabajador')->findOrFail($id);

        $tareas = Tarea::where('user_id', $trabajador->user_id)
            ->with('usuario')
            ->orderBy('FechaProgramada')
            ->get();

        $tareasPorDia = $tareas->groupBy(function ($t) {
            return $t->FechaProgramada
                ? \Carbon\Carbon::parse($t->FechaProgramada)->format('Y-m-d')
                : 'Sin fecha';
        });

        return view('tareas.tareasTrabajador', compact('trabajador', 'tareasPorDia'));
    }



}
