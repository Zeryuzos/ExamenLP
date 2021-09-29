<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{
    public $posts, $nombre, $tipo, $sexo, $edad, $descripcion, $post_id;
    public $isOpen = 0;

    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->nombre = '';
        $this->tipo = '';
        $this->sexo = '';
        $this->edad = '';
        $this->descripcion = '';
        $this->post_id = '';
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
            'tipo' => 'required',
            'sexo' => 'required',
            'edad' => 'required',
            'descripcion' => 'required',
        ]);

        Post::updateOrCreate(['id' => $this->post_id], [
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'sexo' => $this->sexo,
            'edad' => $this->edad,
            'descripcion' => $this->descripcion,
        ]);

        session()->flash('message', 
            $this->post_id ? 'Post Updated Successfully.' : 'Post Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->nombre = $post->nombre;
        $this->tipo = $post->tipo;
        $this->sexo = $post->sexo;
        $this->edad = $post->edad;
        $this->descripcion = $post->descripcion;

        $this->openModal();
    }


    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }
}