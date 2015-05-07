Vagrant.configure("2") do |config|

  config.vm.box = "puphpet/debian75-x32"
  config.vm.hostname = "myproject"
  
  config.ssh.forward_agent = true
  config.vm.boot_timeout = 1000

  config.vm.network :private_network, ip: "192.168.56.101"
  config.vm.network :forwarded_port, guest: 3306, host: 1234  #MYSQL
  
  config.vm.synced_folder "./", "/var/www", id: "vagrant-root"

  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = "puppet/manifests"
    puppet.module_path = "puppet/modules"
    puppet.options = ['--verbose']
  end
  
  config.vm.provider :virtualbox do |vb|
    vb.customize ["modifyvm", :id, "--memory", "512"]
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.customize ["modifyvm", :id, "--cpus", "2"]
   end

end
