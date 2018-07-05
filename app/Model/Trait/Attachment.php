<?php namespace App\Model\Trait;

/*
 *  Model : Attachment
 *
 */

trait Attachment
{
    
    /**
     * File to be process
     *
     * @var string
     *
     */
    
    public $file ;
    
    
    /**
     * File in these sizes will created.
     *
     * @var array $sizes
     */
    protected $sizes;
    
    /*
     * The Generated file name
     */
    
    protected $filename;
    
    /**
     * The temporary path of the upladed file.
     *
     * @var string
     */
    
    public $path;
    
    /**
     * The module name of related file
     * @var string
     */
    
    public $module;
    
    
        
    public static function attachFile($file, $module, array $options = array())
    {
        $instance = new Attachment();
        $instance->client = \Config::get('app.client');
        return $instance->saveFile($file, $module, $options);
    }
    
    public static function getAttachFile($attacheCode)
    {
        $attachment = Attachment::where('attach_code', $attacheCode)->first();
        if ($attachment) {
            return $attachment;
        } else {
            return false;
        }
    }
    
    public static function deleteAttachFile($attacheCode)
    {
        $attachment = Attachment::getAttachFile($attacheCode);
        if ($attachment) {
            $client = \Config::get('app.client');
            $file = $attachment->module_type.DIRECTORY_SEPARATOR.$attachment->file_name ;
            if (\Storage::disk($client->slug)->exists($file)) {
                if (\Storage::disk($client->slug)->delete($file)) {
                    return Attachment::where('attach_code', $attacheCode)->delete();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    
    /**
     * Saves the file.
     *
     * When saves a file, it persists the model and move the uploaded file into the place.
     *
     * @param array $options
     *
     * @return bool
     */
    public function saveFile($file, $module, array $options = array())
    {

        // Set all parameter of file
        $this->setFile($file, $module);
        //print_r($file); die;
        // Move the file to define folder
        if ($this->moveFile()) {

                // Resize file if it is an image
            if (isset($options['resize']) && $options['resize'] &&
                        isset($options['width']) && isset($options['height'])) {
                // Check file if is image
                if ($this->is_image()) {

                                    // Client storage path
                    $path = \Storage::disk($this->client->slug)->getDriver()
                                ->getAdapter()->getPathPrefix() ;

                    // Main file path
                    $file = $this->module . DIRECTORY_SEPARATOR . $this->filename ;

                    // Thumb folder path
                    $thumb_folder = $path . $this->module.DIRECTORY_SEPARATOR . 'thumb';

                    // Thumb file path with name
                    $thumb_file = $thumb_folder.DIRECTORY_SEPARATOR.$this->filename ;

                    if (!\Storage::disk($this->client->slug)->exists($thumb_file)) {
                        if (!\File::isDirectory($thumb_folder)) {
                            \File::makeDirectory($thumb_folder, 0775, true);
                        }

                        $image = \Image::make($path.$file);
                        $image->resize($options['width'], $options['height']);
                        $image->save($thumb_file);
                    }
                }
            }

            $data['attach_code'] = $this->generateCode();
            $data['module_type'] = $this->module;
            $data['file_name'] = $this->filename;
            $data['original_file_name'] = $this->originalfilename;
            $data['extension'] = $this->ext;
            $data['file_type'] = $this->mime_content_type($this->filename, $file);
            $data['size'] = $this->size;
            $data['created_by'] = Auth::user()->id;
                
            if (isset($options['is_bulk'])) {
                $data['is_bulk'] = self::IS_BULK_NOT_PROCESSED;
            }
                
            if (Attachment::create($data)) {
                return $data['attach_code'] ;
            } else {
                return false;
            }
        }
    }
        
    private function mime_content_type($filename, $file)
    {

            //mime_content_type replacement that uses Fileinfo native to php>=5.3.0
        /* if (phpversion() >= '5.3.0') {

             $result = new finfo();

             if (is_resource($result) === true) {
                 var_dump($result->file($filename, FILEINFO_MIME_TYPE)); die;
                 return $result->file($filename, FILEINFO_MIME_TYPE);
             }
         } else {*/

        if (substr($filename, -5, 5) == '.docx') {
            return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        } elseif (substr($filename, -5, 5) == '.xlsx') {
            return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        } elseif (substr($filename, -5, 5) == '.pptx') {
            return 'application/vnd.openxmlformats-officedocument.spreadsheetml.presentation';
        }
        //amend this with manual overrides to your heart's desire

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file);
        return $mime;
        /*  }*/
    }

    /**
     * Sets model instance attributes.
     *
     * @param string $path
     *
     * @return void
     */
    public function setFile($file, $module)
    {
        $this->module = $module; // Set the module
        $this->file = $file; // Set the file
        $this->filename = $this->generateFileName(); // generate the file name
        $this->size = $file->getSize();
        //$this->file_type = $file->getMimeType();
    }
    
    public function generateFileName()
    {
        if ($this->file->getExtension() == 'tmp' || $this->file->getExtension() == '') {
           // For uploading single resume
            $this->ext =$this->file->getClientOriginalExtension();
            $this->originalfilename = $this->file->getClientOriginalName();
        } else {
            // For uploading resume from Bulk
            $this->ext = $this->file->getExtension();
            $this->originalfilename = $this->file->getRelativePathname();
        }
        $name = uniqid() . '_' . time() . '.' . $this->ext; // Create a unique name

        if (\Storage::disk($this->client->slug)->exists($this->module.DIRECTORY_SEPARATOR.$name)) {
            $name = $this->generateFileName();
        }
        return $name ;
    }
    
    private function generateCode()
    {
        return uniqid().time() ;
    }
    
    public function moveFile()
    {
        if (\Storage::disk($this->client->slug)->put(
            $this->basePath(),
                        file_get_contents($this->file->getRealPath())
        )) {
            return true;
        } else {
            return false;
        }
    }
    
    /*
     * Check file is image or not
     */
    public function is_image()
    {
        if (substr($this->file->getMimeType(), 0, 5) == 'image') {
            return true;
        } else {
            return false ;
        }
    }
    
    private function basePath()
    {
        return $this->module.DIRECTORY_SEPARATOR.$this->filename ;
    }
    
    /**
     * set attachment status to active
     * @param $attachment
     */
    public static function setActive($attachment_code)
    {
        return Attachment::where('attach_code', $attachment_code)
                ->update(['is_active' => 'Yes']);
    }
    
    public function candidate()
    {
        return $this->hasOne(
                'App\model\client\admin\model\Candidate',
                    'attach_code',
                'reume'
            );
    }
        
    public static function unProcessedAttachments()
    {
        return self::where(['is_bulk' => self::IS_BULK_NOT_PROCESSED,
                        'module_type' => 'resume'])
                    ->leftJoin('users', 'attachments.created_by', '=', 'users.id')
                    ->select(
                        'attachments.id',
                        'file_name',
                        'original_file_name',
                        'extension',
                        'name',
                        'attach_code',
                        'attachments.created_at',
                        'attachments.created_by',
                        'attachments.deleted_at'
                    )
                    ->orderBy('attachments.created_at', 'desc')
                    ->get();
    }
        
    public static function setBulkProcess($code)
    {
        return self::where('attach_code', $code)
                    ->update(array('is_bulk' => self::IS_BULK_PROCESSED));
    }
    /*
     * $image = \Image::make(sprintf('uploads/profile/%s', $name))
            ->resize(50,50)
            ->save(sprintf('uploads/profile/thumb/%s', $name));
     *
     */
    public static function getResumePath($attach_id, $module =  'resume')
    {
        $client = \Config::get('app.client');
        $path = \Storage::disk($client->slug)->getDriver()
                                ->getAdapter()->getPathPrefix() ;

        $filename = Attachment::where('attach_code', $attach_id)
                ->select('file_name')->get()->toArray();

        if($filename) {
           return $path . $module . DIRECTORY_SEPARATOR . @$filename[0]['file_name'] ;
        }
        return false;
    }
    
     /**
     * Delete Resume
     * @param $post
     * @return boolean
     */
    public static function DeleteResume($ids)
    {
        $is_resumes = self::whereIn('id', $ids)->count();
        
        if ($is_resumes) {
            if(Attachment::destroy($ids)) {
                return true;
            } else {
                return false;
            }
        } 
        return false;
    }
}
