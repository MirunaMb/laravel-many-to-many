<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Project; //importo il modello del Project

class ProjectPublished extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $project; //in questo modo si puo usare tutto quello che tiene project->variabili del project

    public function __construct(Project $project) //Riceve un ogetto Post,riceve il parametro project
    {
        $this->project = $project; //this -si riferisce alla public function di sopra che la valorizziamo con il parametro
        //questa riga rende disponibile il project al interno di tutta la Mail
    } 

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope() 
    {
    $status = $this->project->published ? 'Published' : 'Removed';

        return new Envelope(
            subject: 'Project ' .$status,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $project = $this->project;
        return new Content(
            view: 'mail.published',
            with: compact('project')  // array associattivo
            //si puo scrivere anche cosi array associattivo
            // [
            //     'project'=> $project, 
            // ]  
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
