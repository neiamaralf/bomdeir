import { Component, ElementRef, OnInit, ViewChild } from "@angular/core";
import { UserService } from "../../shared/user/user.service";
import { RouterExtensions } from "nativescript-angular/router";

@Component({
  templateUrl: "./home.html",
  moduleId: module.id,
})
export class HomeComponent implements OnInit {
  isLoggingIn = true;
  admin = false;

  @ViewChild("container") container: ElementRef;

  constructor(private routerExtensions:RouterExtensions,public userService: UserService) {
  }

  gotopage(page) {
    switch (page) {
      case 'onde':
        var loc;
        //this.locationService.getEndFromlatlong(loc);
        this.routerExtensions.navigate(["/items"], { clearHistory: false });
        //console.dir(loc);
        break;
      case 'oque':
        this.routerExtensions.navigate(["/items"], { clearHistory: false });
        break;
    }
  }


  ngOnInit() {

  }


}
