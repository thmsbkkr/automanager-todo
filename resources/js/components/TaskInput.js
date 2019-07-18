import React, { Component } from 'react';

export default class TaskInput extends Component {
  constructor (props) {
    super (props)

    this.addTask = this.addTask.bind(this)
  }

  addTask(event) {
    if (event.key === 'Enter') {
      this.props.addTask({
        body: event.target.value
      })

      event.target.value = ''
    }
  }

  render() {
    return (
      <div className="card">
        <div className="card-body">
          <input className="form-control" onKeyPress={this.addTask} placeholder="Add task and press"></input>
        </div>
      </div>
    );
  }
}
