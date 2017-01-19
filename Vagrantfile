#!/usr/bin/env ruby

# Include the config file
begin
    require 'dotenv'
    Dotenv.load './.env'
rescue LoadError; end

# Vagrant workings
Vagrant.configure(2) do |config|

    config.vm.box = ENV.fetch('VAGRANT_BOX', 'ubuntu-14.04')
    config.vm.box_url = ENV.fetch('VAGRANT_BOX_URL', 'https://oss-binaries.phusionpassenger.com/vagrant/boxes/latest/ubuntu-14.04-amd64-vbox.box')

    config.vm.hostname = ENV.fetch('APP_DOMAIN')

    config.vm.network "private_network", ip: ENV.fetch('APP_IP')

    config.vm.synced_folder ".", "/vagrant", disabled: true
    config.vm.synced_folder "./", ENV.fetch('NGINX_ROOT', '/var/www'), create: true

    config.vm.provider :virtualbox do |vb|
        vb.customize [
            "modifyvm", :id,
            "--name", ENV.fetch('APP_DOMAIN'),
            "--memory", ENV.fetch('VAGRANT_MEMORY', 1024),
            "--natdnshostresolver1", "on",
            "--cpus", ENV.fetch('VAGRANT_CPUS', 1)
        ]
    end

    config.vm.provision "ansible" do |ansible|
        ansible.playbook = ENV.fetch('ANSIBLE_PLAYBOOK', './server/ansible/development.yml')
        ansible.extra_vars = {
            'provis_fqdn' => ENV.fetch('APP_DOMAIN'),
            'provis_secure_site' => false,
            'system_env' => ENV.fetch('APP_ENV', 'development'),
            'system_user' => ENV.fetch('SYSTEM_USER', 'vagrant'),
            'system_group' => ENV.fetch('SYSTEM_GROUP', 'vagrant'),
            'php_listen' => ENV.fetch('PHP_LISTEN', '127.0.0.1:9000'),
            'php_display_errors' => 'on',
            'php_short_tags' => 'off',
            'nginx_root' => ENV.fetch('NGINX_ROOT', '/var/www'),
            'nginx_server_name' => ENV.fetch('APP_DOMAIN'),
            'mysql_root_password' => '768e2bdjs',
            'mysql_web_user' => ENV.fetch('DB_USERNAME', 'web'),
            'mysql_web_password' => ENV.fetch('DB_PASSWORD', '72G53K6Bn04VZgf'),
            'mysql_host' => ENV.fetch('DB_HOST', 'localhost'),
            'mysql_database' => ENV.fetch('DB_DATABASE', 'vagrant')
        }
    end

end
